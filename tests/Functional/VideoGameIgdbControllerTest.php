<?php

namespace App\Tests\Functional;

use App\Entity\Developer;
use App\Entity\Editor;
use App\Entity\GameConsole;
use App\Entity\VideoGame;
use App\Service\Igdb\IgdbService;
use App\Service\Igdb\TwitchAuthService;
use App\Tests\BaseFunctionnalCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class VideoGameIgdbControllerTest extends BaseFunctionnalCase
{
    public function testAdminCanSearchIgdbGamesByName(): void
    {
        $this->mockIgdb([
            [
                [
                    'id' => 1942,
                    'name' => 'The Witcher 3: Wild Hunt',
                    'summary' => 'An open-world role-playing game.',
                    'cover' => ['image_id' => 'co1wyy'],
                    'platforms' => [['id' => 167, 'name' => 'PlayStation 5']],
                ],
                [
                    'id' => 9999,
                    'name' => 'Another Witcher Game',
                    'platforms' => [['id' => 6, 'name' => 'PC']],
                ],
            ],
        ]);

        $this->client->loginUser($this->admin);
        $this->client->request(
            'GET',
            '/api/video_games/igdb/search?name=witcher',
        );

        self::assertResponseIsSuccessful();
        $response = json_decode(
            $this->client->getResponse()->getContent(),
            true,
            flags: JSON_THROW_ON_ERROR,
        );
        self::assertCount(2, $response);
        self::assertSame(1942, $response[0]['igdbId']);
        self::assertSame('The Witcher 3: Wild Hunt', $response[0]['name']);
    }

    public function testAdminCanImportSelectedIgdbGame(): void
    {
        $this->mockIgdb([
            [
                [
                    'id' => 1942,
                    'name' => 'The Witcher 3: Wild Hunt',
                    'rating' => 92.4,
                    'cover' => ['image_id' => 'co1wyy'],
                    'platforms' => [['id' => 167, 'name' => 'PlayStation 5']],
                    'involved_companies' => [
                        [
                            'company' => ['id' => 908, 'name' => 'CD Projekt Red'],
                            'developer' => true,
                            'publisher' => false,
                        ],
                        [
                            'company' => ['id' => 909, 'name' => 'CD Projekt'],
                            'developer' => false,
                            'publisher' => true,
                        ],
                    ],
                ],
            ],
        ]);

        $this->client->loginUser($this->admin);
        $this->client->request(
            'POST',
            '/api/video_games/igdb/import',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'igdbId' => 1942,
                'platformIgdbIds' => [167],
            ], JSON_THROW_ON_ERROR),
        );

        self::assertResponseStatusCodeSame(201);

        $videoGame = $this->entityManager()
            ->getRepository(VideoGame::class)
            ->findOneBy(['igdbId' => 1942]);

        self::assertNotNull($videoGame);
        self::assertSame('The Witcher 3: Wild Hunt', $videoGame->getName());
        self::assertSame(92.4, $videoGame->getIgdbRating());
        self::assertNull($videoGame->getRating());
        self::assertCount(1, $videoGame->getConsoles());
        self::assertNotNull($this->entityManager()->getRepository(GameConsole::class)->findOneBy([
            'igdbId' => 167,
            'name' => 'PlayStation 5',
        ]));
        self::assertNotNull($this->entityManager()->getRepository(Developer::class)->findOneBy([
            'igdbId' => 908,
            'name' => 'CD Projekt Red',
        ]));
        self::assertNotNull($this->entityManager()->getRepository(Editor::class)->findOneBy([
            'igdbId' => 909,
            'name' => 'CD Projekt',
        ]));
    }

    private function mockIgdb(array $igdbPayloads): void
    {
        $responses = [
            new MockResponse(json_encode([
                'access_token' => 'test-token',
                'expires_in' => 3600,
            ], JSON_THROW_ON_ERROR)),
        ];

        foreach ($igdbPayloads as $payload) {
            $responses[] = new MockResponse(json_encode($payload, JSON_THROW_ON_ERROR));
        }

        $httpClient = new MockHttpClient($responses);
        $authService = new TwitchAuthService(
            $httpClient,
            new ArrayAdapter(),
            'test-client-id',
            'test-client-secret',
        );

        static::getContainer()->set(
            IgdbService::class,
            new IgdbService($httpClient, $authService, 'test-client-id'),
        );
    }

    private function entityManager(): EntityManagerInterface
    {
        return static::getContainer()->get(EntityManagerInterface::class);
    }
}
