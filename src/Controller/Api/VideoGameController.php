<?php

namespace App\Controller\Api;

use App\Controller\BaseCrudController;
use App\Dto\VideoGame\Create;
use App\Dto\VideoGame\Edit;
use App\Entity\VideoGame;

final class VideoGameController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return VideoGame::class;
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
        return ['video_game:read'];
    }
}
