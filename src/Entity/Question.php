<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
Abstract class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateInterval $timeMax = null;

    #[ORM\Column]
    private ?int $scoreMax = null;

    #[ORM\Column]
    private ?int $scoreMin = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(length: 255)]
    private ?string $explanation = null;

    #[ORM\ManyToOne(inversedBy: 'question')]
    private ?UserResponse $userResponse = null;

    #[ORM\ManyToOne(inversedBy: 'question')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeMax(): ?\DateInterval
    {
        return $this->timeMax;
    }

    public function setTimeMax(\DateInterval $timeMax): static
    {
        $this->timeMax = $timeMax;

        return $this;
    }

    public function getScoreMax(): ?int
    {
        return $this->scoreMax;
    }

    public function setScoreMax(int $scoreMax): static
    {
        $this->scoreMax = $scoreMax;

        return $this;
    }

    public function getScoreMin(): ?int
    {
        return $this->scoreMin;
    }

    public function setScoreMin(int $scoreMin): static
    {
        $this->scoreMin = $scoreMin;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): static
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getUserResponse(): ?UserResponse
    {
        return $this->userResponse;
    }

    public function setUserResponse(?UserResponse $userResponse): static
    {
        $this->userResponse = $userResponse;

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
}
