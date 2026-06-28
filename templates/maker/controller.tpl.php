<?= "<?php\n" ?>

namespace App\Controller\Api;

use App\Controller\BaseCrudController;
use App\Dto\<?= $name ?>\Create;
use App\Dto\<?= $name ?>\Edit;
use App\Entity\<?= $name ?>;

final class <?= $name ?>Controller extends BaseCrudController
{
    protected function entityClass(): string
    {
        return <?= $name ?>::class;
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
        return ['<?= $nameLower ?>:read'];
    }
}
