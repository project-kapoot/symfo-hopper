<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startingTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endTime = null;

    #[ORM\Column(length: 10)]
    private ?string $mode = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $presenter = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'sessions')]
    private Collection $participants;

    /**
     * @var Collection<int, UserResponse>
     */
    #[ORM\OneToMany(targetEntity: UserResponse::class, mappedBy: 'session')]
    private Collection $userResponses;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->userResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingTime(): ?\DateTimeInterface
    {
        return $this->startingTime;
    }

    public function setStartingTime(\DateTimeInterface $startingTime): static
    {
        $this->startingTime = $startingTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(string $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getPresenter(): ?User
    {
        return $this->presenter;
    }

    public function setPresenter(?User $presenter): static
    {
        $this->presenter = $presenter;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(User $participant): static
    {
        $this->participants->removeElement($participant);

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
            $userResponse->setSession($this);
        }

        return $this;
    }

    public function removeUserResponse(UserResponse $userResponse): static
    {
        if ($this->userResponses->removeElement($userResponse)) {
            // set the owning side to null (unless already changed)
            if ($userResponse->getSession() === $this) {
                $userResponse->setSession(null);
            }
        }

        return $this;
    }
}
