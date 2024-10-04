<?php

namespace App\Entity;

use App\Repository\CrochetPatternRepository;
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

    #[ORM\Column(length: 255)]
    private ?string $Designer = null;

    #[ORM\ManyToOne(inversedBy: 'patterns')]
    private ?PatternCollection $collection = null;
    
    
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

    public function getDesigner(): ?string
    {
        return $this->Designer;
    }

    public function setDesigner(string $Designer): static
    {
        $this->Designer = $Designer;

        return $this;
    }
    
    public function getCollection(): ?PatternCollection
    {
        return $this->collection;
    }
    
    public function setCollection(?PatternCollection $collection): static
    {
        $this->collection = $collection;
        
        return $this;
    }
    
    public function __toString(): string
    {
        return $this->Name;
    }
}
