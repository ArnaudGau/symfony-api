<?php

namespace App\Dto\VideoGame;

use Symfony\Component\Validator\Constraints as Assert;

class CreateByIgdb
{
    #[Assert\NotNull]
    #[Assert\Positive]
    public ?int $igdbId = null;

    #[Assert\Count(min: 1)]
    #[Assert\Unique]
    #[Assert\All([
        new Assert\Type('integer'),
        new Assert\Positive(),
    ])]
    public array $platformIgdbIds = [];
}
