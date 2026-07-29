<?php

namespace App\Controller\Api;

use App\Controller\BaseCrudController;
use App\Dto\Developer\Create;
use App\Dto\Developer\Edit;
use App\Entity\Developer;

final class DeveloperController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return Developer::class;
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
        return ['developer:read'];
    }
}
