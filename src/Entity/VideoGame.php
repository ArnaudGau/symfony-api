<?php

namespace App\Entity;

use App\Repository\VideoGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: VideoGameRepository::class)]
class VideoGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['videoGame:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['videoGame:read'])]
    private ?string $cover = null;

    #[ORM\ManyToOne(inversedBy: 'videoGames')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['videoGame:read', 'gameConsole:read'])]
    private ?GameConsole $console = null;

    /**
     * @var Collection<int, Developer>
     */
    #[ORM\ManyToMany(targetEntity: Developer::class, inversedBy: 'videoGames')]
    #[Groups(['videoGame:read', 'developer:read'])]
    private Collection $developer;

    /**
     * @var Collection<int, Editor>
     */
    #[ORM\ManyToMany(targetEntity: Editor::class, inversedBy: 'videoGames')]
    #[Groups(['videoGame:read', 'editor:read'])]
    private Collection $editor;

    #[ORM\Column(nullable: true)]
    #[Groups(['videoGame:read'])]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['videoGame:read'])]
    private ?int $rating = null;

    public function __construct()
    {
        $this->developer = new ArrayCollection();
        $this->editor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getConsole(): ?GameConsole
    {
        return $this->console;
    }

    public function setConsole(?GameConsole $console): static
    {
        $this->console = $console;

        return $this;
    }

    /**
     * @return Collection<int, Developer>
     */
    public function getDeveloper(): Collection
    {
        return $this->developer;
    }

    public function addDeveloper(Developer $developer): static
    {
        if (!$this->developer->contains($developer)) {
            $this->developer->add($developer);
        }

        return $this;
    }

    public function removeDeveloper(Developer $developer): static
    {
        $this->developer->removeElement($developer);

        return $this;
    }

    /**
     * @return Collection<int, Editor>
     */
    public function getEditor(): Collection
    {
        return $this->editor;
    }

    public function addEditor(Editor $editor): static
    {
        if (!$this->editor->contains($editor)) {
            $this->editor->add($editor);
        }

        return $this;
    }

    public function removeEditor(Editor $editor): static
    {
        $this->editor->removeElement($editor);

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }
}
