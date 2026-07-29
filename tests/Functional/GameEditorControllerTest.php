<?php

namespace App\Tests\Functional;

use App\Entity\GameEditor;

class GameEditorControllerTest extends AbstractGameCatalogControllerCase
{
    protected function entityClass(): string
    {
        return GameEditor::class;
    }

    protected function url(): string
    {
        return '/api/game_editors';
    }
}
