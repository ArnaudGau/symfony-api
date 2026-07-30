<?php

namespace App\Entity;

use App\Repository\DeveloperRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
class Developer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['developer:read'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true, unique: true)]
    #[Groups(['developer:read'])]
    private ?int $igdbId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['developer:read'])]
    private ?string $name = null;

    /**
     * @var Collection<int, VideoGame>
     */
    #[ORM\ManyToMany(targetEntity: VideoGame::class, mappedBy: 'developer')]
    private Collection $videoGames;

    public function __construct()
    {
        $this->videoGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getIgdbId(): ?int
    {
        return $this->igdbId;
    }

    public function setIgdbId(int $igdbId): static
    {
        $this->igdbId = $igdbId;

        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, VideoGame>
     */
    public function getVideoGames(): Collection
    {
        return $this->videoGames;
    }

    public function addVideoGame(VideoGame $videoGame): static
    {
        if (!$this->videoGames->contains($videoGame)) {
            $this->videoGames->add($videoGame);
            $videoGame->addDeveloper($this);
        }

        return $this;
    }

    public function removeVideoGame(VideoGame $videoGame): static
    {
        if ($this->videoGames->removeElement($videoGame)) {
            $videoGame->removeDeveloper($this);
        }

        return $this;
    }
}
