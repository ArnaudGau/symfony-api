// templates/maker/api/controller.tpl.php
<?= "<?php\n" ?>

namespace App\Controller\Api;

use App\Repository\<?= $name ?>Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Dto\<?= $name ?>\Create
use App\Dto\<?= $name ?>\Update
use App\Controller\BaseCrudController;


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