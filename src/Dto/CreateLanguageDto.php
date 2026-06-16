<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateLanguageDto
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 3)]
    public ?string $code = null;
}