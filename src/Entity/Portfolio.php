<?php

namespace App\Entity;

use App\Repository\PortfolioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Member;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'portfolios', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreated = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalPatterns = null;

    #[ORM\ManyToMany(targetEntity: CrochetPattern::class, inversedBy: 'portfolios')]
    private Collection $patterns;

    public function __construct()
    {
        $this->patterns = new ArrayCollection();
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

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTimeInterface $dateCreated): static
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getTotalPatterns(): ?int
    {
        return $this->totalPatterns;
    }

    public function setTotalPatterns(?int $totalPatterns): static
    {
        $this->totalPatterns = $totalPatterns;

        return $this;
    }

    /**
     * @return Collection<int, Member>
     */
    
    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        if ($this->member !== $member) {
            $this->member = $member;
            if ($member !== null && !$member->getPortfolios()->contains($this)) {
                $member->addPortfolio($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, CrochetPattern>
     */
    public function getPatterns(): Collection
    {
        return $this->patterns;
    }

    public function addPattern(CrochetPattern $pattern): static
    {
        if (!$this->patterns->contains($pattern)) {
            $this->patterns->add($pattern);
        }

        return $this;
    }

    public function removePattern(CrochetPattern $pattern): static
    {
        $this->patterns->removeElement($pattern);

        return $this;
    }
}
