<?php

namespace App\Entity;

use App\Repository\UserResponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserResponseRepository::class)]
class UserResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userChoice = null;

    #[ORM\Column(nullable: true)]
    private ?int $responseTime = null;

    #[ORM\Column(nullable: true)]
    private ?int $score = null;

    #[ORM\ManyToOne(inversedBy: 'userResponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\ManyToOne(inversedBy: 'userResponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;

    #[ORM\ManyToOne(inversedBy: 'userResponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $respondingUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserChoice(): ?string
    {
        return $this->userChoice;
    }

    public function setUserChoice(?string $userChoice): static
    {
        $this->userChoice = $userChoice;

        return $this;
    }

    public function getResponseTime(): ?int
    {
        return $this->responseTime;
    }

    public function setResponseTime(?int $responseTime): static
    {
        $this->responseTime = $responseTime;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getRespondingUser(): ?User
    {
        return $this->respondingUser;
    }

    public function setRespondingUser(?User $respondingUser): static
    {
        $this->respondingUser = $respondingUser;

        return $this;
    }
}
