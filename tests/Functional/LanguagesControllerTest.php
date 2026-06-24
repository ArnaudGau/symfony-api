<?php

namespace App\Tests\Functional;

use App\Tests\BaseFunctionnalCase;

class LanguagesControllerTest extends BaseFunctionnalCase
{
    protected string $url;
    protected array $languages = [];

    public function setUp(): void
    {
        parent::setUp();
        $this->url = '/api/languages';
        $this->languages = [
            'name' => 'Test language '.$this->faker->unique()->word(),
            'code' => strtolower($this->faker->unique()->lexify('??')),
        ];
    }

    public function testAdminCanCreateLanguage(): void
    {
        $this->postClient('admin', $this->url, $this->languages);

        self::assertResponseStatusCodeSame(201);
    }

    public function testUserCannotCreateLanguage(): void
    {
        $this->postClient('user', $this->url, $this->languages);

        self::assertResponseStatusCodeSame(403);
    }
}
