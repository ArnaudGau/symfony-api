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
            'name' => 'Test language ',
            'code' => 'te',
        ];
    }

    public function test_admin_can_create_language(): void
    {
        $this->postClient('admin', $this->url, $this->languages);

        self::assertResponseStatusCodeSame(201);
    }

    public function test_user_cannot_create_language(): void
    {
        $this->postClient('user', $this->url, $this->languages);

        self::assertResponseStatusCodeSame(403);
    }
}
