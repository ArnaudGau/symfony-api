<?php

namespace App\Dto\DictionnaryUser;

use Symfony\Component\Validator\Constraints as Assert;

class Answer
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public ?int $dictionnary_id = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $answer = null;
}
