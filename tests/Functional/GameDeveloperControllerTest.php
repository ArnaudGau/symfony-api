<?php

namespace App\Tests\Functional;

use App\Entity\GameDeveloper;

class GameDeveloperControllerTest extends AbstractGameCatalogControllerCase
{
    protected function entityClass(): string
    {
        return GameDeveloper::class;
    }

    protected function url(): string
    {
        return '/api/game_developers';
    }
}
