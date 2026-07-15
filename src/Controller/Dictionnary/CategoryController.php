<?php

namespace App\Controller\Dictionnary;

use App\Controller\BaseCrudController;
use App\Dto\Category\Create;
use App\Dto\Category\Edit;
use App\Entity\Category;

final class CategoryController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return Category::class;
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
        return ['category:read'];
    }
}
