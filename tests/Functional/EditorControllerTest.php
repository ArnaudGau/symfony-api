<?php

namespace App\Tests\Functional;

use App\Entity\Editor;

class EditorControllerTest extends AbstractGameCatalogControllerCase
{
    protected function entityClass(): string
    {
        return Editor::class;
    }

    protected function url(): string
    {
        return '/api/editors';
    }
}
