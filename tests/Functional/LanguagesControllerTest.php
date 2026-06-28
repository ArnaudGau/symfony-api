<?php

namespace App\Tests\Functional;

use App\Tests\BaseFunctionnalCase;
use App\Tests\Helper\LanguagesFactory;

class LanguagesControllerTest extends BaseFunctionnalCase
{
    protected string $url;
    protected array $languages = [];

    public function setUp(): void
    {
        parent::setUp();
        $this->url = '/api/languages';
        $this->languages = [
            'name' => 'Test language ' . $this->faker->unique()->word(),
            'code' => strtolower($this->faker->unique()->lexify('??')),
        ];
    }

    public function testAdminCanCreateLanguage(): void
    {
        $this->postUrl('admin', $this->url, $this->languages);

        self::assertResponseStatusCodeSame(201);
    }

    public function testUserCannotCreateLanguage(): void
    {
        $this->postUrl('user', $this->url, $this->languages);

        self::assertResponseStatusCodeSame(403);
    }

    public function testAdminCanGetLanguage(): void
    {
        $name = $this->faker->unique()->word();
        $code = $this->faker->unique()->lexify('??');

        $language = LanguagesFactory::create(
            $this->entityManager,
            $name,
            $code
        );

        $this->getUrl('admin', $this->url . '/' . $language->getId());
        self::assertResponseStatusCodeSame(200);
    }
}
