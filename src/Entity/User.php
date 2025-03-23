<?php

namespace App\Entity;

use App\Repository\AuthRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AuthRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]

    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Quizz>
     */
    #[ORM\OneToMany(targetEntity: Quizz::class, mappedBy: 'author')]
    private Collection $quizzes;

    /**
     * @var Collection<int, UserResponse>
     */
    #[ORM\OneToMany(targetEntity: UserResponse::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $userResponses;

    public function __construct()
    {
        $this->quizzes = new ArrayCollection();
        $this->userResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
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

    /**
     * @return Collection<int, Quizz>
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quizz $quizz): static
    {
        if (!$this->quizzes->contains($quizz)) {
            $this->quizzes->add($quizz);
            $quizz->setAuthor($this);
        }

        return $this;
    }

    public function removeQuiz(Quizz $quizz): static
    {
        if ($this->quizzes->removeElement($quizz)) {
            // set the owning side to null (unless already changed)
            if ($quizz->getAuthor() === $this) {
                $quizz->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserResponse>
     */
    public function getUserResponses(): Collection
    {
        return $this->userResponses;
    }

    public function addUserResponse(UserResponse $userResponse): static
    {
        if (!$this->userResponses->contains($userResponse)) {
            $this->userResponses->add($userResponse);
            $userResponse->setPlayer($this);
        }

        return $this;
    }

    public function removeUserResponse(UserResponse $userResponse): static
    {
        if ($this->userResponses->removeElement($userResponse)) {
            // set the owning side to null (unless already changed)
            if ($userResponse->getPlayer() === $this) {
                $userResponse->setPlayer(null);
            }
        }

        return $this;
    }
}