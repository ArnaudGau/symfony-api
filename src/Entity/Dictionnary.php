<?php

namespace App\Entity;

use App\Repository\DictionnaryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DictionnaryRepository::class)]
class Dictionnary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'word')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Languages $language = null;

    #[ORM\Column(length: 255)]
    private ?string $word = null;

    #[ORM\Column(length: 255)]
    private ?string $translation = null;

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
}
