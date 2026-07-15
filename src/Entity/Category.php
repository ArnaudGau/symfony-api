<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'dictionnary_categories')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read', 'dictionnary:read', 'dictionnary_user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'dictionnary:read', 'dictionnary_user:read'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Dictionnary>
     */
    #[ORM\OneToMany(targetEntity: Dictionnary::class, mappedBy: 'category')]
    private Collection $dictionnaries;

    public function __construct()
    {
        $this->dictionnaries = new ArrayCollection();
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

    /**
     * @return Collection<int, Dictionnary>
     */
    public function getDictionnaries(): Collection
    {
        return $this->dictionnaries;
    }

    public function addDictionnary(Dictionnary $dictionnary): static
    {
        if (!$this->dictionnaries->contains($dictionnary)) {
            $this->dictionnaries->add($dictionnary);
            $dictionnary->setCategory($this);
        }

        return $this;
    }

    public function removeDictionnary(Dictionnary $dictionnary): static
    {
        if ($this->dictionnaries->removeElement($dictionnary)) {
            if ($dictionnary->getCategory() === $this) {
                $dictionnary->setCategory(null);
            }
        }

        return $this;
    }
}
