<?php

namespace App\Dto\DictionnaryUser;

use Symfony\Component\Validator\Constraints as Assert;

class Edit
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public ?int $dictionnary_id = null;
}
