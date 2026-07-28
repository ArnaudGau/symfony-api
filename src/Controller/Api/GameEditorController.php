<?php

namespace App\Controller\Api;

use App\Controller\BaseCrudController;
use App\Dto\GameEditor\Create;
use App\Dto\GameEditor\Edit;
use App\Entity\GameEditor;

final class GameEditorController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return GameEditor::class;
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
        return ['game_editor:read'];
    }
}
