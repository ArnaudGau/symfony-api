<?php

namespace App\Controller\Api;

use App\Controller\BaseCrudController;
use App\Dto\Editor\Create;
use App\Dto\Editor\Edit;
use App\Entity\Editor;

final class EditorController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return Editor::class;
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
        return ['editor:read'];
    }
}
