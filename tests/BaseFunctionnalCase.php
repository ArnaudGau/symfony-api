<?php

namespace App\Tests;

use App\Entity\User;
use App\Tests\Helper\UserFactory;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseFunctionnalCase extends WebTestCase
{
    protected KernelBrowser $client;
    protected User $admin;
    protected User $user;
    protected Generator $faker;

    public function setUp(): void
    {
        $this->client = static::createClient([
            'environment' => 'test',
            'debug' => false,
        ]);
        $this->faker = Factory::create('fr_FR');
        $this->admin = $this->persistUser(UserFactory::admin());
        $this->user = $this->persistUser(UserFactory::user());
    }

    private function persistUser($user)
    {
        $user->setEmail(uniqid('', true) . '-' . $user->getEmail());

        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    private function getheaders(array $headers)
    {
        if (empty($headers)) {
            $headers = ['CONTENT_TYPE' => 'application/json'];
        }

        return $headers;
    }

    private function connectUser(string $user)
    {
        switch ($user) {
            case 'admin':
                $this->client->loginUser($this->admin);
                break;
            case 'user':
                $this->client->loginUser($this->user);
                break;
            default:
                throw new \Exception('user role not excist');
        }
    }

    public function postClient(string $user, string $url, array $parameters = [], array $headers = [])
    {
        $this->connectUser($user);
        $headers = $this->getheaders($headers);
        $this->client->request('POST', $url, [], [], $headers, json_encode($parameters));
    }
}
