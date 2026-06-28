<?php

namespace App\Entity;

use App\Repository\LanguagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: LanguagesRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQUE_CODE_NAME', fields: ['code', 'name'])]
class Languages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['language:read', 'dictionnary:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['language:read', 'dictionnary:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 3)]
    #[Groups(['language:read', 'dictionnary:read'])]
    private ?string $code = null;

    /**
     * @var Collection<int, Dictionnary>
     */
    #[ORM\OneToMany(targetEntity: Dictionnary::class, mappedBy: 'language')]
    private Collection $word;

    public function __construct()
    {
        $this->word = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Dictionnary>
     */
    public function getWord(): Collection
    {
        return $this->word;
    }

    public function addWord(Dictionnary $word): static
    {
        if (!$this->word->contains($word)) {
            $this->word->add($word);
            $word->setLanguage($this);
        }

        return $this;
    }

    public function removeWord(Dictionnary $word): static
    {
        if ($this->word->removeElement($word)) {
            // set the owning side to null (unless already changed)
            if ($word->getLanguage() === $this) {
                $word->setLanguage(null);
            }
        }

        return $this;
    }
}
