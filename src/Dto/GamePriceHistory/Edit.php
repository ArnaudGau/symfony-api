<?php

namespace App\Dto\GamePriceHistory;

use Symfony\Component\Validator\Constraints as Assert;

class Edit
{
    #[Assert\Regex('/^\d{1,8}\.\d{2}$/')]
    public ?string $price = null;

    public ?\DateTimeInterface $date = null;
}
