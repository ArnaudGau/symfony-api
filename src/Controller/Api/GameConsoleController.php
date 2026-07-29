<?php

namespace App\Controller\Api;

use App\Controller\BaseCrudController;
use App\Dto\GameConsole\Create;
use App\Dto\GameConsole\Edit;
use App\Entity\GameConsole;

final class GameConsoleController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return GameConsole::class;
    }

    protected function getDtoCreate(): string
    {
        return Create::class;
    }

    protected function getDtoUpdate(): string
    {
        return Edit::class;
    }

    protected function getReadGroups(): array
    {
        return ['game_console:read'];
    }
}
