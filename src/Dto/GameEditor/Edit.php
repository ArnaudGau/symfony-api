<?php

namespace App\Dto\GameEditor;

use Symfony\Component\Validator\Constraints as Assert;

class Edit
{
    #[Assert\Length(max: 255)]
    public ?string $name = null;
}
