<?php

namespace App\Dto\VideoGame;

use Symfony\Component\Validator\Constraints as Assert;

class Create
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $name = null;

    #[Assert\Length(max: 255)]
    public ?string $cover = null;

    #[Assert\NotNull]
    #[Assert\Positive]
    public ?float $price = null;

    #[Assert\NotNull]
    #[Assert\Positive]
    public ?int $rating = null;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public ?int $console_id = null;

    #[Assert\NotBlank]
    #[Assert\Count(min: 1)]
    #[Assert\All([
        new Assert\Type('integer'),
        new Assert\Positive(),
    ])]
    public array $editorIds = [];

    #[Assert\NotBlank]
    #[Assert\Count(min: 1)]
    #[Assert\All([
        new Assert\Type('integer'),
        new Assert\Positive(),
    ])]
    public array $developerIds = [];
}
