<?php

namespace App\Tests\Functional;

use App\Tests\Helper\UserFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LanguagesControllerTest extends WebTestCase
{
    public function test_admin_can_create_language(): void
    {
        /** @var KernelBrowser $client */
        $client = static::createClient();
        $client->loginUser($this->persistUser(UserFactory::admin()));

        $suffix = (string) random_int(100, 999);

        $client->request('POST', '/api/languages', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'name' => 'Test language '.$suffix,
            'code' => 't'.substr($suffix, 0, 2),
        ]));

        self::assertResponseStatusCodeSame(201);
    }

    public function test_user_cannot_create_language(): void
    {
        /** @var KernelBrowser $client */
        $client = static::createClient();
        $client->loginUser($this->persistUser(UserFactory::user()));

        $client->request('POST', '/api/languages', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'name' => 'French',
            'code' => 'fr',
        ]));

        self::assertResponseStatusCodeSame(403);
    }

    private function persistUser($user)
    {
        $user->setEmail(uniqid('', true).'-'.$user->getEmail());

        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }
}
