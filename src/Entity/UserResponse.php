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
    private ?int $responseScore = null;

    #[ORM\Column]
    private ?int $responseTime = null;

    #[ORM\ManyToOne(inversedBy: 'userResponses')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?User $player = null;

    #[ORM\ManyToOne(inversedBy: 'userResponses')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?SessionQuizz $sessionQuizz = null;

    #[ORM\ManyToOne(inversedBy: 'userResponses')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Question $question = null;

    /**
     * @var Collection<int, Answer>
     */
    #[ORM\ManyToMany(targetEntity: Answer::class, mappedBy: 'userResponse')]
    private Collection $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponseScore(): ?int
    {
        return $this->responseScore;
    }

    public function setResponseScore(int $responseScore): static
    {
        $this->responseScore = $responseScore;

        return $this;
    }

    public function getResponseTime(): ?int
    {
        return $this->responseTime;
    }

    public function setResponseTime(int $responseTime): static
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

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): static
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->addUserResponse($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): static
    {
        if ($this->answers->removeElement($answer)) {
            $answer->removeUserResponse($this);
        }

        return $this;
    }
}
