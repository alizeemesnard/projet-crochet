<?php

namespace App\Entity;

use App\Repository\patternCollectionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: patternCollectionRepository::class)]
class patternCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Member::class, inversedBy: 'patternCollection')]
    private ?Member $Designer = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateCreated = null;

    #[ORM\Column]
    private ?int $TotalPatterns = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\OneToMany(mappedBy: 'patternCollection', targetEntity: CrochetPattern::class, cascade: ['persist', 'remove'])]
    private Collection $patterns;
    
    public function __construct()
    {
        $this->patterns = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesigner(): ?Member
    {
        return $this->Designer;
    }

    public function setDesigner(?Member $Designer): static
    {
        $this->Designer = $Designer;
        
        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->DateCreated;
    }

    public function setDateCreated(\DateTimeInterface $DateCreated): static
    {
        $this->DateCreated = $DateCreated;

        return $this;
    }

    public function getTotalPatterns(): ?int
    {
        return $this->TotalPatterns;
    }

    public function setTotalPatterns(int $TotalPatterns): static
    {
        $this->TotalPatterns = $TotalPatterns;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }
    
    public function getPatterns(): Collection
    {
        return $this->patterns;
    }
    
    public function addPattern(CrochetPattern $pattern): self
    {
        if (!$this->patterns->contains($pattern)) {
            $this->patterns[] = $pattern;
            $pattern->setCollection($this);
        }
        
        return $this;
    }
    
    public function removePattern(CrochetPattern $pattern): self
    {
        if ($this->patterns->removeElement($pattern)) {
            // Set the owning side to null (unless already changed)
            if ($pattern->getCollection() === $this) {
                $pattern->setCollection(null);
            }
        }
        
        return $this;
    }
    
    public function __toString(): string
    {
        return $this->Name;
    }
    
}
