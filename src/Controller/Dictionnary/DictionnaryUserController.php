<?php

namespace App\Controller\Dictionnary;

use App\Controller\BaseCrudController;
use App\Dto\DictionnaryUser\Answer;
use App\Dto\DictionnaryUser\Create;
use App\Dto\DictionnaryUser\Edit;
use App\Entity\Dictionnary;
use App\Entity\DictionnaryUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DictionnaryUserController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return DictionnaryUser::class;
    }

    protected function getDtoCreate(): string
    {
        return Create::class;
    }

    protected function getDtoUpdate(): string
    {
        return Edit::class;
    }

    protected function getDtoAnswer(): string
    {
        return Answer::class;
    }

    protected function getReadGroups(): array
    {
        return ['dictionnary_user:read'];
    }

    public function create(Request $request): JsonResponse
    {
        $dtoClass = $this->getDtoCreate();
        $dto = $this->validateDto($request, $dtoClass);

        $repository = $this->getRepository();

        if (!method_exists($repository, 'create')) {
            $this->logError('function create is mandatory', ['' => $dtoClass, 'entity' => $this->entityClass()]);

            throw new \LogicException(sprintf('Repository for "%s" must implement a create() method.', $this->entityClass()));
        }

        $user = $this->getUser();
        $isCorrect = $dto->isCorrect ?? true;
        $entity = $repository->create($dto, $user, $isCorrect);

        return $this->json($entity, Response::HTTP_CREATED, [], [
            'groups' => $this->getReadGroups(),
        ]);
    }

    public function answer(Request $request): JsonResponse
    {
        $dtoClass = $this->getDtoAnswer();
        $dto = $this->validateDto($request, $dtoClass);
        $repository = $this->getRepository();
        $dictionnaryRepo = $this->entityManager->getRepository(Dictionnary::class);

        $user = $this->getUser();
        $dictionnary = $dictionnaryRepo->find($dto->dictionnary_id);

        if (!$dictionnary) {
            return $this->json(['message' => 'Dictionnary not found'], Response::HTTP_NOT_FOUND);
        }

        $isCorrect = strtolower(trim($dto->answer)) === strtolower(trim($dictionnary->getTranslation()));

        $entity = $repository->create($dto, $user, $isCorrect);

        return $this->json([
            'correct' => $isCorrect,
            'word' => $dictionnary->getWord(),
            'translation' => $dictionnary->getTranslation(),
            'completion' => $entity->getCompletion(),
        ]);
    }
}
