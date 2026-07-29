<?php

namespace App\Tests\Functional;

use App\Tests\BaseFunctionnalCase;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractGameCatalogControllerCase extends BaseFunctionnalCase
{
    abstract protected function entityClass(): string;

    abstract protected function url(): string;

    public function testAdminCanListEntities(): void
    {
        $entity = $this->persistEntity('List '.$this->faker->unique()->company());
        $expectedCount = $this->repository()->count([]);

        $this->request('GET', $this->url());

        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('json');
        self::assertCount(
            $expectedCount,
            json_decode($this->client->getResponse()->getContent(), true, flags: JSON_THROW_ON_ERROR),
        );
        self::assertNotNull($this->repository()->find($entity->getId()));
    }

    public function testAdminCanCreateEntity(): void
    {
        $name = 'Create '.$this->faker->unique()->company();

        $this->request('POST', $this->url(), ['name' => $name]);

        self::assertResponseStatusCodeSame(201);
        self::assertNotNull($this->repository()->findOneBy(['name' => $name]));
    }

    public function testAdminCanUpdateEntity(): void
    {
        $entity = $this->persistEntity('Before '.$this->faker->unique()->company());
        $newName = 'After '.$this->faker->unique()->company();

        $this->request('PUT', $this->url().'/'.$entity->getId(), ['name' => $newName]);

        self::assertResponseIsSuccessful();
        $this->entityManager()->refresh($entity);
        self::assertSame($newName, $entity->getName());
    }

    public function testAdminCanDeleteEntity(): void
    {
        $entity = $this->persistEntity('Delete '.$this->faker->unique()->company());
        $id = $entity->getId();

        $this->request('DELETE', $this->url().'/'.$id);

        self::assertResponseIsSuccessful();
        self::assertSame(
            ['message' => 'Entity deleted successfully'],
            json_decode($this->client->getResponse()->getContent(), true),
        );
        self::assertNull($this->repository()->find($id));
    }

    private function request(string $method, string $url, array $payload = []): void
    {
        $this->client->loginUser($this->admin);
        $this->client->request(
            $method,
            $url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            [] === $payload ? null : json_encode($payload, JSON_THROW_ON_ERROR),
        );
    }

    private function persistEntity(string $name): object
    {
        $entityClass = $this->entityClass();
        $entity = (new $entityClass())->setName($name);

        $this->entityManager()->persist($entity);
        $this->entityManager()->flush();

        return $entity;
    }

    private function entityManager(): EntityManagerInterface
    {
        return static::getContainer()->get(EntityManagerInterface::class);
    }

    private function repository(): object
    {
        return $this->entityManager()->getRepository($this->entityClass());
    }
}
