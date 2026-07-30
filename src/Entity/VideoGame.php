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
    #[Groups(['video_game:read'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true, unique: true)]
    #[Groups(['video_game:read'])]
    private ?int $igdbId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['video_game:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['video_game:read'])]
    private ?string $cover = null;

    /**
     * @var Collection<int, GameConsole>
     */
    #[ORM\ManyToMany(targetEntity: GameConsole::class, inversedBy: 'videoGames')]
    #[Groups(['video_game:read', 'gameConsole:read'])]
    private Collection $consoles;

    /**
     * @var Collection<int, Developer>
     */
    #[ORM\ManyToMany(targetEntity: Developer::class, inversedBy: 'videoGames')]
    #[Groups(['video_game:read', 'developer:read'])]
    private Collection $developer;

    /**
     * @var Collection<int, Editor>
     */
    #[ORM\ManyToMany(targetEntity: Editor::class, inversedBy: 'videoGames')]
    #[Groups(['video_game:read', 'editor:read'])]
    private Collection $editor;

    #[ORM\Column(nullable: true)]
    #[Groups(['video_game:read'])]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['video_game:read'])]
    private ?float $igdbRating = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['video_game:read'])]
    private ?int $rating = null;

    public function __construct()
    {
        $this->developer = new ArrayCollection();
        $this->editor = new ArrayCollection();
        $this->consoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    #[Groups(['video_game:read'])]
    public function getCoverUrl(): ?array
    {
        if (!$this->cover) {
            return null;
        }

        $baseUrl = 'https://images.igdb.com/igdb/image/upload';

        return [
            'small' => sprintf(
                '%s/t_cover_small/%s.jpg',
                $baseUrl,
                $this->cover,
            ),
            'medium' => sprintf(
                '%s/t_cover_big/%s.jpg',
                $baseUrl,
                $this->cover,
            ),
            'large' => sprintf(
                '%s/t_cover_big_2x/%s.jpg',
                $baseUrl,
                $this->cover,
            ),
        ];
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return Collection<int, GameConsole>
     */
    public function getConsoles(): Collection
    {
        return $this->consoles;
    }

    public function addConsole(GameConsole $console): static
    {
        if (!$this->consoles->contains($console)) {
            $this->consoles->add($console);
        }

        return $this;
    }

    public function removeConsole(GameConsole $console): static
    {
        $this->consoles->removeElement($console);

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

    public function getIgdbRating(): ?float
    {
        return $this->igdbRating;
    }

    public function setIgdbRating(?float $igdbRating): static
    {
        $this->igdbRating = $igdbRating;

        return $this;
    }
}
