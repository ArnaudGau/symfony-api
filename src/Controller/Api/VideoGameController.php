<?php

namespace App\Controller\Api;

use App\Controller\BaseCrudController;
use App\Dto\VideoGame\Create;
use App\Dto\VideoGame\CreateByIgdb;
use App\Dto\VideoGame\Edit;
use App\Dto\VideoGame\Rating;
use App\Entity\VideoGame;
use App\Repository\VideoGameRepository;
use App\Service\Igdb\IgdbService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class VideoGameController extends BaseCrudController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        LoggerInterface $logger,
        private readonly IgdbService $igdbService,
    ) {
        parent::__construct($entityManager, $serializer, $validator, $logger);
    }

    protected function entityClass(): string
    {
        return VideoGame::class;
    }

    protected function getDtoCreate(): string
    {
        return Create::class;
    }

    protected function getDtoUpdate(): string
    {
        return Edit::class;
    }

    protected function getReadGroups(): array
    {
        return [
            'video_game:read',
            'game_console:read',
            'developer:read',
            'editor:read',
        ];
    }

    public function searchIgdb(Request $request): JsonResponse
    {
        $name = trim((string) $request->query->get('name'));
        $console = trim((string) $request->query->get('console'));

        if ('' === $name) {
            throw new BadRequestHttpException('Le paramètre name est obligatoire.');
        }

        $results = $this->igdbService->search($name);

        if ('' !== $console) {
            $normalizedConsole = strtolower($console);
            $results = array_filter(
                $results,
                static fn (array $game): bool => array_any(
                    $game['platforms'] ?? [],
                    static fn (array $platform): bool => str_contains(
                        strtolower((string) ($platform['name'] ?? '')),
                        $normalizedConsole,
                    ),
                ),
            );
        }

        return $this->json(array_map(
            static fn (array $game): array => [
                'igdbId' => $game['id'],
                'name' => $game['name'],
                'summary' => $game['summary'] ?? null,
                'cover' => $game['cover']['image_id'] ?? null,
                'platforms' => $game['platforms'] ?? [],
            ],
            array_values($results),
        ));
    }

    public function createByIgdb(Request $request): JsonResponse
    {
        /** @var CreateByIgdb $dto */
        $dto = $this->validateDto($request, CreateByIgdb::class);

        /** @var VideoGameRepository $repository */
        $repository = $this->getRepository();

        if ($repository->findOneBy(['igdbId' => $dto->igdbId])) {
            throw new ConflictHttpException('Ce jeu IGDB a déjà été importé.');
        }

        $igdbGame = $this->igdbService->findById($dto->igdbId);

        if (!$igdbGame) {
            throw new NotFoundHttpException('Jeu IGDB introuvable.');
        }

        $availablePlatformIds = array_map(
            static fn (array $platform): int => (int) $platform['id'],
            $igdbGame['platforms'] ?? [],
        );
        $missingPlatformIds = array_diff($dto->platformIgdbIds, $availablePlatformIds);

        if ([] !== $missingPlatformIds) {
            throw new BadRequestHttpException(sprintf('Plateformes IGDB invalides pour ce jeu : %s.', implode(', ', $missingPlatformIds)));
        }

        $videoGame = $repository->createByIgdb($dto, $igdbGame);

        return $this->json($videoGame, Response::HTTP_CREATED, [], [
            'groups' => $this->getReadGroups(),
        ]);
    }

    public function rating(Request $request, int $id): JsonResponse
    {
        /** @var Rating $dto */
        $dto = $this->validateDto($request, Rating::class);

        /** @var VideoGameRepository $repository */
        $repository = $this->getRepository();
        $videoGame = $repository->find($id);

        if (!$videoGame) {
            throw new NotFoundHttpException('Jeu introuvable.');
        }

        return $this->json(
            $repository->updateRating($videoGame, $dto->rating),
            Response::HTTP_OK,
            [],
            ['groups' => $this->getReadGroups()],
        );
    }
}
