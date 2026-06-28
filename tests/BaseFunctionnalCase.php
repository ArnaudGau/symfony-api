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
    protected EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->faker = Factory::create('fr_FR');
        $this->admin = $this->persistUser(UserFactory::admin());
        $this->user = $this->persistUser(UserFactory::user());
    }

    private function persistUser($user)
    {
        $user->setEmail(uniqid('', true).'-'.$user->getEmail());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

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

    public function postUrl(string $user, string $url, array $parameters = [], array $headers = [])
    {
        $this->connectUser($user);
        $headers = $this->getheaders($headers);
        $this->client->request('POST', $url, [], [], $headers, json_encode($parameters));
    }

    public function putUrl(string $user, string $url, array $parameters = [], array $headers = [])
    {
       $this->connectUser($user);
        $headers = $this->getheaders($headers);
        $this->client->request('PUT', $url, [], [], $headers, json_encode($parameters));
    }

    public function getUrl(string $user, string $url, array $headers = [])
    {
        $this->connectUser($user);
        $headers = $this->getheaders($headers);
        $this->client->request('GET', $url, [], [], $headers);
    }
}
