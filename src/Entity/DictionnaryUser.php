<?php

namespace App\Entity;

use App\Repository\DictionnaryUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: DictionnaryUserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQUE_USER_DICTIONNARY', fields: ['user', 'dictionnary'])]
class DictionnaryUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['dictionnary_user:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userDictionnaries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'dictionnaryUsers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['dictionnary_user:read'])]
    private ?Dictionnary $dictionnary = null;

    #[ORM\Column(options: ['default' => 0])]
    #[Groups(['dictionnary_user:read'])]
    private int $completion = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDictionnary(): ?Dictionnary
    {
        return $this->dictionnary;
    }

    public function setDictionnary(?Dictionnary $dictionnary): static
    {
        $this->dictionnary = $dictionnary;

        return $this;
    }

    public function getCompletion(): int
    {
        return $this->completion;
    }

    public function setCompletion(int $completion): static
    {
        $this->completion = $completion;

        return $this;
    }
}
