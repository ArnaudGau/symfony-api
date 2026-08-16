<?php

namespace App\Dto\VideoGame;

use Symfony\Component\Validator\Constraints as Assert;

final class Rating
{
    #[Assert\Range(min: 0, max: 5)]
    public ?int $rating = null;
}
