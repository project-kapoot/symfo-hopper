<?php

namespace App\Entity;

use App\Repository\QuestionNumeriqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionNumeriqueRepository::class)]
class QuestionNumerique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $correctAnswer = null;

    #[ORM\Column]
    private ?float $tolerance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCorrectAnswer(): ?int
    {
        return $this->correctAnswer;
    }

    public function setCorrectAnswer(int $correctAnswer): static
    {
        $this->correctAnswer = $correctAnswer;

        return $this;
    }

    public function getTolerance(): ?float
    {
        return $this->tolerance;
    }

    public function setTolerance(float $tolerance): static
    {
        $this->tolerance = $tolerance;

        return $this;
    }
}
