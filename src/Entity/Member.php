<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Member implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'Designer', targetEntity: patternCollection::class)]
    private ?patternCollection $patternCollection = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Portfolio::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $portfolios;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function __construct()
    {
        $this->portfolios = new ArrayCollection();
    }
    
    public function addPortfolio(Portfolio $portfolio): self
    {
        if (!$this->portfolios->contains($portfolio)) {
            $this->portfolios->add($portfolio);
            $portfolio->setMember($this);
        }
        
        return $this;
    }
    
    public function removePortfolio(Portfolio $portfolio): self
    {
        if ($this->portfolios->removeElement($portfolio)) {
            if ($portfolio->getMember() === $this) {
                $portfolio->setMember(null);
            }
        }
        
        return $this;
    }
    
    public function getPortfolios(): Collection
    {
        return $this->portfolios;
    }

    public function setPortfolios(Collection $portfolios): self
    {
        foreach ($portfolios as $portfolio) {
            $this->addPortfolio($portfolio);
        }
        return $this;
    }
    
    public function __toString(): string
    {
        return $this->email;
    }
}
