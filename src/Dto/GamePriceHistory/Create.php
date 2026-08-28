<?php

namespace App\Dto\GamePriceHistory;

use Symfony\Component\Validator\Constraints as Assert;

class Create
{
    #[Assert\NotBlank]
    #[Assert\Regex('/^\d{1,8}\.\d{2}$/')]
    public ?string $price = null;

    #[Assert\NotBlank]
    public ?\DateTimeInterface $date = null;
}
