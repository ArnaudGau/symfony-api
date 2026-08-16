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
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'gamePriceHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VideoGame $game = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['game_price_history:read'])]
    private ?string $price = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['game_price_history:read'])]

    private ?\DateTime $date = null;

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

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }
}
