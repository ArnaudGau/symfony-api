<?php

namespace App\Repository;

use App\Dto\VideoGame\CreateByIgdb;
use App\Entity\Developer;
use App\Entity\Editor;
use App\Entity\GameConsole;
use App\Entity\VideoGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VideoGame>
 */
class VideoGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoGame::class);
    }

    public function createByIgdb(
        CreateByIgdb $dto,
        array $igdbGame,
    ): VideoGame {
        $videoGame = (new VideoGame())
            ->setIgdbId($dto->igdbId)
            ->setName($igdbGame['name'])
            ->setCover($igdbGame['cover']['image_id'] ?? null)
            ->setIgdbRating(isset($igdbGame['rating']) ? (float) $igdbGame['rating'] : null);

        foreach ($igdbGame['platforms'] ?? [] as $platform) {
            if (in_array((int) $platform['id'], $dto->platformIgdbIds, true)) {
                $videoGame->addConsole($this->findOrCreateConsole($platform));
            }
        }

        foreach ($igdbGame['involved_companies'] ?? [] as $involvedCompany) {
            $companyId = (int) ($involvedCompany['company']['id'] ?? 0);
            $companyName = trim($involvedCompany['company']['name'] ?? '');

            if (0 === $companyId || '' === $companyName) {
                continue;
            }

            if ($involvedCompany['developer'] ?? false) {
                $videoGame->addDeveloper($this->findOrCreateDeveloper($companyId, $companyName));
            }

            if ($involvedCompany['publisher'] ?? false) {
                $videoGame->addEditor($this->findOrCreateEditor($companyId, $companyName));
            }
        }

        $this->getEntityManager()->persist($videoGame);
        $this->getEntityManager()->flush();

        return $videoGame;
    }

    private function findOrCreateConsole(array $platform): GameConsole
    {
        $entityManager = $this->getEntityManager();
        $console = $entityManager->getRepository(GameConsole::class)->findOneBy([
            'igdbId' => (int) $platform['id'],
        ]);

        if (!$console) {
            $console = (new GameConsole())->setIgdbId((int) $platform['id']);
            $entityManager->persist($console);
        }

        $console->setName($platform['name']);

        return $console;
    }

    private function findOrCreateEditor(int $igdbId, string $name): Editor
    {
        $entityManager = $this->getEntityManager();
        $editor = $entityManager->getRepository(Editor::class)->findOneBy(['igdbId' => $igdbId]);

        if (!$editor) {
            $editor = (new Editor())->setIgdbId($igdbId);
            $entityManager->persist($editor);
        }

        $editor->setName($name);

        return $editor;
    }

    private function findOrCreateDeveloper(int $igdbId, string $name): Developer
    {
        $entityManager = $this->getEntityManager();
        $developer = $entityManager->getRepository(Developer::class)->findOneBy(['igdbId' => $igdbId]);

        if (!$developer) {
            $developer = (new Developer())->setIgdbId($igdbId);
            $entityManager->persist($developer);
        }

        $developer->setName($name);

        return $developer;
    }
}
