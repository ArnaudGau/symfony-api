<?php

namespace App\Dto\VideoGame;

use Symfony\Component\Validator\Constraints as Assert;

class Edit
{
    #[Assert\Length(max: 255)]
    public ?string $name = null;

    #[Assert\Length(max: 255)]
    public ?string $cover = null;

    #[Assert\Positive]
    public ?float $price = null;

    #[Assert\Positive]
    public ?int $rating = null;

    #[Assert\Type('integer')]
    public ?int $console_id = null;

    #[Assert\Count(min: 1)]
    #[Assert\All([
        new Assert\Type('integer'),
        new Assert\Positive(),
    ])]
    public array $editorIds = [];

    #[Assert\Count(min: 1)]
    #[Assert\All([
        new Assert\Type('integer'),
        new Assert\Positive(),
    ])]
    public array $developerIds = [];
}
