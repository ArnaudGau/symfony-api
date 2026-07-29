<?php

namespace App\Controller\Api;

use App\Controller\BaseCrudController;
use App\Dto\GameDeveloper\Create;
use App\Dto\GameDeveloper\Edit;
use App\Entity\GameDeveloper;

final class GameDeveloperController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return GameDeveloper::class;
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
        return ['game_developer:read'];
    }
}
