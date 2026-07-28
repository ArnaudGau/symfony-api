<?php

namespace App\Service\Igdb;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class TwitchAuthService
{
    private const TOKEN_CACHE_KEY = 'igdb.twitch_access_token';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly CacheInterface $cache,
        private readonly string $igdbClientId,
        private readonly string $igdbClientSecret,
    ) {
    }

    public function getAccessToken(): string
    {
        return $this->cache->get(
            self::TOKEN_CACHE_KEY,
            function (ItemInterface $item): string {
                $response = $this->httpClient->request(
                    'POST',
                    'https://id.twitch.tv/oauth2/token',
                    [
                        'query' => [
                            'client_id' => $this->igdbClientId,
                            'client_secret' => $this->igdbClientSecret,
                            'grant_type' => 'client_credentials',
                        ],
                    ],
                );

                $data = $response->toArray();

                if (!isset($data['access_token'], $data['expires_in'])) {
                    throw new \RuntimeException(
                        'Impossible de récupérer le token Twitch.',
                    );
                }

                // Petite marge avant l’expiration réelle.
                $ttl = max(60, ((int) $data['expires_in']) - 300);

                $item->expiresAfter($ttl);

                return $data['access_token'];
            },
        );
    }

    public function clearAccessToken(): void
    {
        $this->cache->delete(self::TOKEN_CACHE_KEY);
    }
}