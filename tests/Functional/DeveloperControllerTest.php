<?php

namespace App\Tests\Functional;

use App\Entity\Developer;

class DeveloperControllerTest extends AbstractGameCatalogControllerCase
{
    protected function entityClass(): string
    {
        return Developer::class;
    }

    protected function url(): string
    {
        return '/api/developers';
    }
}
