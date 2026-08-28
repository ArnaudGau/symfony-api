<?php

namespace App\Service\Ollama;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OllamaPriceEstimator
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $ollamaUrl,
        private readonly string $ollamaModel,
    ) {
    }

    /**
     * @param list<string> $platforms
     */
    public function estimate(string $gameName, array $platforms): string
    {
        $response = $this->httpClient->request('POST', rtrim($this->ollamaUrl, '/').'/api/generate', [
            'timeout' => 120,
            'json' => [
                'model' => $this->ollamaModel,
                'stream' => false,
                'format' => [
                    'type' => 'object',
                    'properties' => [
                        'price' => [
                            'type' => 'string',
                            'description' => 'Estimated price in EUR with exactly two decimals.',
                            'pattern' => '^[0-9]{1,8}[.][0-9]{2}$',
                        ],
                    ],
                    'required' => ['price'],
                    'additionalProperties' => false,
                ],
                'options' => [
                    'temperature' => 0.1,
                ],
                'prompt' => sprintf(
                    "Estimate the current average second-hand market price in France for this video game.\nGame: %s\nPlatforms: %s\nReturn only the requested JSON. The price must be in EUR and must not include a currency symbol.",
                    $gameName,
                    [] === $platforms ? 'unknown' : implode(', ', $platforms),
                ),
            ],
        ]);

        $payload = $response->toArray(false);
        $generatedContent = $payload['response'] ?? null;

        if (!is_string($generatedContent)) {
            throw new \RuntimeException('Ollama returned no generated content.');
        }

        try {
            $estimate = json_decode($generatedContent, true, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new \RuntimeException('Ollama returned invalid JSON.', previous: $exception);
        }

        if (!is_array($estimate) || !isset($estimate['price'])) {
            throw new \RuntimeException('Ollama returned no price.');
        }

        return $this->normalizeDecimal((string) $estimate['price']);
    }

    private function normalizeDecimal(string $price): string
    {
        $price = str_replace(',', '.', trim($price));

        if (!preg_match('/^\d{1,8}(?:\.\d{1,2})?$/D', $price)) {
            throw new \RuntimeException(sprintf('Ollama returned an invalid price: "%s".', $price));
        }

        [$integer, $decimal] = array_pad(explode('.', $price, 2), 2, '');
        $integer = ltrim($integer, '0');

        return ('' === $integer ? '0' : $integer).'.'.str_pad($decimal, 2, '0');
    }
}
