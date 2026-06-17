<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseCrudController extends AbstractController
{
    abstract protected function entityClass(): string;

    abstract protected function getDtoCreate(): string;
    abstract protected function getDtoUpdate(): string;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected SerializerInterface $serializer,
        protected ValidatorInterface $validator,
    ) {}

    protected function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository($this->entityClass());
    }

    protected function validateDto(Request $request, string $dtoClass): object
    {
        try {
            $dto = $this->serializer->deserialize(
                $request->getContent(),
                $dtoClass,
                'json'
            );
        } catch (\Throwable $e) {
            throw new BadRequestHttpException('Invalid JSON payload');
        }

        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $messages = [];

            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }

            throw new BadRequestHttpException(json_encode($messages));
        }

        return $dto;
    }

    protected function getReadGroups(): array
    {
        return ['read'];
    }

    public function index(): JsonResponse
    {
        $entities = $this->getRepository()->findAll();

        return $this->json($entities, 200, [], [
            'groups' => $this->getReadGroups(),
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $dtoClass = $this->getDtoCreate();
        $dto = $this->validateDto($request, $dtoClass);

        $repository = $this->getRepository();

        if (!method_exists($repository, 'create')) {
            throw new \LogicException(sprintf(
                'Repository for "%s" must implement a create() method.',
                $this->entityClass()
            ));
        }

        $entity = $repository->create($dto);

        return $this->json($entity, Response::HTTP_CREATED, [], [
            'groups' => $this->getReadGroups(),
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $dtoClass = $this->getDtoUpdate();
        $dto = $this->validateDto($request, $dtoClass);

        $repository = $this->getRepository();

        if (!method_exists($repository, 'update')) {
            throw new \LogicException(sprintf(
                'Repository for "%s" must implement an update() method.',
                $this->entityClass()
            ));
        }
        $model = $repository->find($id);
        $entity = $repository->update($model, $dto);

        return $this->json($entity, 200, [], [
            'groups' => $this->getReadGroups(),
        ]);
    }

    public function delete(Request $request, $id): JsonResponse
    {
        $repository = $this->getRepository();
        $entity = $repository->find($id);

        if (!$entity) {
            return $this->json(['message' => 'Entity not found'], 404);
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return $this->json(['message' => 'Entity deleted successfully'], 200);
    }
}
