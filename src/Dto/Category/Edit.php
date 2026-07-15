<?php

namespace App\Dto\Category;

use Symfony\Component\Validator\Constraints as Assert;

class Edit
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $name = null;
}
