<?php

namespace App\Entity;

use App\Repository\UserResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserResponseRepository::class)]
class UserResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column]
    private ?int $score = null;

    #[ORM\Column]
    private ?\DateInterval $responseTime = null;

    #[ORM\ManyToOne(inversedBy: 'userResponses')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?User $player = null;

    #[ORM\ManyToOne(inversedBy: 'userResponses')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?SessionQuizz $sessionQuizz = null;

    #[ORM\ManyToOne(inversedBy: 'userResponses')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Question $question = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getResponseTime(): ?\DateInterval
    {
        return $this->responseTime;
    }

    public function setResponseTime(\DateInterval $responseTime): static
    {
        $this->responseTime = $responseTime;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): static
    {
        $this->player = $player;

        return $this;
    }

    public function getSessionQuizz(): ?SessionQuizz
    {
        return $this->sessionQuizz;
    }

    public function setSessionQuizz(?SessionQuizz $sessionQuizz): static
    {
        $this->sessionQuizz = $sessionQuizz;

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
}
