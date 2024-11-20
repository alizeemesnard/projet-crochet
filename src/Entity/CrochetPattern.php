<?php

namespace App\Entity;

use App\Repository\CrochetPatternRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CrochetPatternRepository::class)]
class CrochetPattern
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(nullable: true)]
    private ?float $HookSize = null;

    #[ORM\Column(length: 255)]
    private ?string $Category = null;

    #[ORM\Column(length: 255)]
    private ?string $Language = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $Image = [];

    #[ORM\ManyToOne(inversedBy: 'patterns')]
    private ?patternCollection $patternCollection = null;

    /**
     * @var Collection<int, Portfolio>
     */
    #[ORM\ManyToMany(targetEntity: Portfolio::class, mappedBy: 'patterns')]
    private Collection $portfolios;

    public function __construct()
    {
        $this->portfolios = new ArrayCollection();
    }
    
    
    public function getId(): ?int
    {
        return $this->id;
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

    public function getHookSize(): ?float
    {
        return $this->HookSize;
    }

    public function setHookSize(?float $HookSize): static
    {
        $this->HookSize = $HookSize;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->Language;
    }

    public function setLanguage(string $Language): static
    {
        $this->Language = $Language;

        return $this;
    }

    public function getImage(): array
    {
        return $this->Image;
    }

    public function setImage(array $Image): static
    {
        $this->Image = $Image;

        return $this;
    }
    
    public function getPatternCollection(): ?patternCollection
    {
        return $this->patternCollection;
    }
    
    public function setPatternCollection(?patternCollection $patternCollection): static
    {
        $this->patternCollection = $patternCollection;
        
        return $this;
    }
    
    public function __toString(): string
    {
        return $this->Name;
    }

    /**
     * @return Collection<int, Portfolio>
     */
    public function getPortfolios(): Collection
    {
        return $this->portfolios;
    }

    public function addPortfolio(Portfolio $portfolio): static
    {
        if (!$this->portfolios->contains($portfolio)) {
            $this->portfolios->add($portfolio);
            $portfolio->addPattern($this);
        }

        return $this;
    }

    public function removePortfolio(Portfolio $portfolio): static
    {
        if ($this->portfolios->removeElement($portfolio)) {
            $portfolio->removePattern($this);
        }

        return $this;
    }
}
