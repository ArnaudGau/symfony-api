<?php

namespace App\Tests\Unit;

use App\Service\Ollama\OllamaPriceEstimator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

final class OllamaPriceEstimatorTest extends TestCase
{
    public function testItReturnsANormalizedDecimalPrice(): void
    {
        $httpClient = new MockHttpClient(static function (string $method, string $url, array $options): MockResponse {
            self::assertSame('POST', $method);
            self::assertSame('http://ollama:11434/api/generate', $url);
            self::assertStringContainsString('Final Fantasy X', $options['body']);
            self::assertStringContainsString('PlayStation 2', $options['body']);

            return new MockResponse(json_encode([
                'response' => json_encode(['price' => '049.9'], JSON_THROW_ON_ERROR),
            ], JSON_THROW_ON_ERROR));
        });
        $estimator = new OllamaPriceEstimator($httpClient, 'http://ollama:11434', 'gemma3:latest');

        self::assertSame('49.90', $estimator->estimate('Final Fantasy X', ['PlayStation 2']));
    }

    public function testItRejectsAnInvalidPrice(): void
    {
        $httpClient = new MockHttpClient(new MockResponse(json_encode([
            'response' => json_encode(['price' => 'environ 50 euros'], JSON_THROW_ON_ERROR),
        ], JSON_THROW_ON_ERROR)));
        $estimator = new OllamaPriceEstimator($httpClient, 'http://ollama:11434', 'gemma3:latest');

        $this->expectException(\RuntimeException::class);
        $estimator->estimate('Final Fantasy X', ['PlayStation 2']);
    }
}
