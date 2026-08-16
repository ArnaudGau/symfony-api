<?php

namespace App\Dto\GamePriceHistory;

use Symfony\Component\Validator\Constraints as Assert;

class Create
{
    #[Assert\NotBlank]
    public ?float $price = null;

    #[Assert\NotBlank]
    public ?\DateTimeInterface $date = null;
}
