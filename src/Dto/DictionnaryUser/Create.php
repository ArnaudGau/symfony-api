<?php

namespace App\Dto\DictionnaryUser;

use Symfony\Component\Validator\Constraints as Assert;

class Create
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public ?int $dictionnary_id = null;

    #[Assert\Type('bool')]
    public ?bool $isCorrect = null;
}
