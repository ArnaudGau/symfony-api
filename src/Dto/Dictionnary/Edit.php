<?php

namespace App\Dto\Dictionnary;

use Symfony\Component\Validator\Constraints as Assert;

class Edit
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public ?int $language_id = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $word = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $translation = null;
}
