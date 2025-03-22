<?php

namespace App\Entity;

use App\Repository\QuestionQCMRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionQCMRepository::class)]
class QuestionQCM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $answers = [];

    #[ORM\Column]
    private array $correctAnswer = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function setAnswers(array $answers): static
    {
        $this->answers = $answers;

        return $this;
    }

    public function getCorrectAnswer(): array
    {
        return $this->correctAnswer;
    }

    public function setCorrectAnswer(array $correctAnswer): static
    {
        $this->correctAnswer = $correctAnswer;

        return $this;
    }
}
