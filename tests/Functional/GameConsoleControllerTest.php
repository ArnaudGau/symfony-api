<?php

namespace App\Tests\Functional;

use App\Entity\GameConsole;

class GameConsoleControllerTest extends AbstractGameCatalogControllerCase
{
    protected function entityClass(): string
    {
        return GameConsole::class;
    }

    protected function url(): string
    {
        return '/api/game_consoles';
    }
}
