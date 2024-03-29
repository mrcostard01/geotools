<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
#[UniqueEntity ('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    
    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $PseudoU = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\Email()]
    #[Assert\Length(min: 2, max: 180)]
    private ?string $email;

    #[ORM\Column(type: 'json')]
    #[Assert\NotNull()]
    private ?array $roles = [];

    private ?string $plainPassword = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank()]
    private ?string $password = 'password';

    #[ORM\ManyToMany(targetEntity: Articles::class, mappedBy: 'Pseudo_M_id')]
    private $articles;

    #[ORM\ManyToMany(targetEntity: Modifications::class, mappedBy: 'Pseudo_M_id')]
    private $modifications;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->modifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function getPseudoU(): ?string
    {
        return $this->PseudoU;
    }

    public function setPseudoU(string $PseudoU): self
    {
        $this->PseudoU = $PseudoU;

        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
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
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    /**
     * avoir la valeur de plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    /**
     * met la valeur de plainPassword
     * 
     * @return self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->addPseudoMId($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            $article->removePseudoMId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Modifications>
     */
    public function getModifications(): Collection
    {
        return $this->modifications;
    }

    public function addModification(Modifications $modification): self
    {
        if (!$this->modifications->contains($modification)) {
            $this->modifications[] = $modification;
            $modification->addPseudoMId($this);
        }

        return $this;
    }

    public function removeModification(Modifications $modification): self
    {
        if ($this->modifications->removeElement($modification)) {
            $modification->removePseudoMId($this);
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    public function __toString() {
        return $this->email;
    }
}
