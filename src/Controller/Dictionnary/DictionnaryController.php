<?php

namespace App\Controller\Dictionnary;

use App\Controller\BaseCrudController;
use App\Dto\Dictionnary\Create;
use App\Dto\Dictionnary\Edit;
use App\Entity\Dictionnary;

class DictionnaryController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return Dictionnary::class;
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
        return ['dictionnary:read'];
    }
}
