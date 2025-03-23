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

    #[ORM\ManyToOne]
    private ?user $player = null;

    #[ORM\Column]
    private ?int $Score = null;

    #[ORM\Column]
    private ?\DateInterval $ResponseTime = null;

    #[ORM\Column(nullable: true)]
    private ?array $userChoice = null;

    /**
     * @var Collection<int, Question>
     */
    #[ORM\OneToMany(targetEntity: Question::class, mappedBy: 'userResponse')]
    private Collection $question;

    public function __construct()
    {
        $this->question = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Question>
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->question->contains($question)) {
            $this->question->add($question);
            $question->setUserResponse($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->question->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getUserResponse() === $this) {
                $question->setUserResponse(null);
            }
        }

        return $this;
    }
}
