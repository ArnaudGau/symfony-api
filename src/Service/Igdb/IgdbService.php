<?php

namespace App\Service\Igdb;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class IgdbService
{
    private const API_URL = 'https://api.igdb.com/v4';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly TwitchAuthService $authService,
        private readonly string $igdbClientId,
    ) {
    }

    public function search(string $title): array
    {
        $query = sprintf(
            'search "%s"; fields id,name,summary,cover.image_id,platforms.name; limit 10;',
            addcslashes($title, '"\\'),
        );

        $response = $this->request('/games', $query);

        return $response->toArray();
    }

    private function request(
        string $endpoint,
        string $body,
        bool $retry = true,
    ): ResponseInterface {
        $token = $this->authService->getAccessToken();

        $response = $this->httpClient->request(
            'POST',
            self::API_URL.$endpoint,
            [
                'headers' => [
                    'Client-ID' => $this->igdbClientId,
                    'Authorization' => 'Bearer '.$token,
                    'Accept' => 'application/json',
                ],
                'body' => $body,
            ],
        );

        if ($response->getStatusCode() === 401 && $retry) {
            $this->authService->clearAccessToken();

            return $this->request($endpoint, $body, false);
        }

        return $response;
    }
}