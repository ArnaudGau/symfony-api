<?php

namespace App\Controller\Api;

use App\Controller\BaseCrudController;
use App\Dto\GamePriceHistory\Create;
use App\Dto\GamePriceHistory\Edit;
use App\Entity\GamePriceHistory;

final class GamePriceHistoryController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return GamePriceHistory::class;
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
        return ['game_price_history:read'];
    }
}
