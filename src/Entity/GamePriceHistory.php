<?php

namespace App\Entity;

use App\Repository\GamePriceHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: GamePriceHistoryRepository::class)]
class GamePriceHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['game_price_history:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'gamePriceHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VideoGame $game = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['game_price_history:read'])]
    private ?string $price = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['game_price_history:read'])]

    private ?\DateTimeImmutable $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?VideoGame
    {
        return $this->game;
    }

    public function setGame(?VideoGame $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }
}
