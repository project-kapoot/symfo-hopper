<?php

namespace App\Entity;

use App\Repository\SessionQuizzRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionQuizzRepository::class)]
class SessionQuizz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $mode = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?user $presenter = null;

    /**
     * @var Collection<int, user>
     */
    #[ORM\ManyToMany(targetEntity: user::class)]
    private Collection $participants;

    #[ORM\ManyToOne]
    private ?Quizz $quizz = null;

    /**
     * @var Collection<int, UserResponse>
     */
    #[ORM\OneToMany(targetEntity: UserResponse::class, mappedBy: 'sessionQuizz', orphanRemoval: true)]
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPresenter(): ?user
    {
        return $this->presenter;
    }

    public function setPresenter(?user $presenter): static
    {
        $this->presenter = $presenter;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(user $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(user $participant): static
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    public function getQuizz(): ?Quizz
    {
        return $this->quizz;
    }

    public function setQuizz(?Quizz $quizz): static
    {
        $this->quizz = $quizz;

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
            $userResponse->setSessionQuizz($this);
        }

        return $this;
    }

    public function removeUserResponse(UserResponse $userResponse): static
    {
        if ($this->userResponses->removeElement($userResponse) && $userResponse->getSessionQuizz() === $this) {
            // set the owning side to null (unless already changed)
            $userResponse->setSessionQuizz(null);
        }

        return $this;
    }
}
