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

    #[ORM\ManyToOne]
    private ?user $player = null;

    #[ORM\Column]
    private ?int $Score = null;

    #[ORM\Column]
    private ?\DateInterval $ResponseTime = null;

    #[ORM\Column(nullable: true)]
    private ?array $userChoice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?user
    {
        return $this->player;
    }

    public function setPlayer(?user $player): static
    {
        $this->player = $player;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->Score;
    }

    public function setScore(int $Score): static
    {
        $this->Score = $Score;

        return $this;
    }

    public function getResponseTime(): ?\DateInterval
    {
        return $this->ResponseTime;
    }

    public function setResponseTime(\DateInterval $ResponseTime): static
    {
        $this->ResponseTime = $ResponseTime;

        return $this;
    }

    public function getUserChoice(): ?array
    {
        return $this->userChoice;
    }

    public function setUserChoice(?array $userChoice): static
    {
        $this->userChoice = $userChoice;

        return $this;
    }
}
