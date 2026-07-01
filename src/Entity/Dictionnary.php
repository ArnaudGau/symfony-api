<?php

namespace App\Entity;

use App\Repository\DictionnaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: DictionnaryRepository::class)]
class Dictionnary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['dictionnary:read', 'dictionnary_user:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'word')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['dictionnary:read', 'dictionnary_user:read'])]
    private ?Languages $language = null;

    #[ORM\Column(length: 255)]
    #[Groups(['dictionnary:read', 'dictionnary_user:read'])]
    private ?string $word = null;

    #[ORM\Column(length: 255)]
    #[Groups(['dictionnary:read', 'dictionnary_user:read'])]
    private ?string $translation = null;

    /**
     * @var Collection<int, DictionnaryUser>
     */
    #[ORM\OneToMany(targetEntity: DictionnaryUser::class, mappedBy: 'dictionnary')]
    private Collection $dictionnaryUsers;

    public function __construct()
    {
        $this->dictionnaryUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): ?Languages
    {
        return $this->language;
    }

    public function setLanguage(?Languages $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): static
    {
        $this->word = $word;

        return $this;
    }

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation): static
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * @return Collection<int, DictionnaryUser>
     */
    public function getDictionnaryUsers(): Collection
    {
        return $this->dictionnaryUsers;
    }

    public function addDictionnaryUser(DictionnaryUser $dictionnaryUser): static
    {
        if (!$this->dictionnaryUsers->contains($dictionnaryUser)) {
            $this->dictionnaryUsers->add($dictionnaryUser);
            $dictionnaryUser->setDictionnary($this);
        }

        return $this;
    }

    public function removeDictionnaryUser(DictionnaryUser $dictionnaryUser): static
    {
        if ($this->dictionnaryUsers->removeElement($dictionnaryUser)) {
            // set the owning side to null (unless already changed)
            if ($dictionnaryUser->getDictionnary() === $this) {
                $dictionnaryUser->setDictionnary(null);
            }
        }

        return $this;
    }
}
