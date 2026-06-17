<?php

namespace App\Controller;

use App\Dto\Languages\Create;
use App\Dto\Languages\Edit;
use App\Entity\Languages;

final class LanguagesController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return Languages::class;
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
        return ['language:read'];
    }
}