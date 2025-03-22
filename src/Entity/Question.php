<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "qcm" => QuestionQCM::class,
    "multi" => QuestionMultichoice::class,
    "num" => QuestionNumerique::class
])]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $timeMax = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $explanation = null;

    #[ORM\Column]
    private ?int $scoreMax = null;

    #[ORM\Column]
    private ?int $scoreMin = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    private ?Quiz $quiz = null;

    /**
     * @var Collection<int, UserResponse>
     */
    #[ORM\OneToMany(targetEntity: UserResponse::class, mappedBy: 'question')]
    private Collection $userResponses;

    public function __construct()
    {
        $this->userResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeMax(): ?int
    {
        return $this->timeMax;
    }

    public function setTimeMax(int $timeMax): static
    {
        $this->timeMax = $timeMax;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

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

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

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
            $userResponse->setQuestion($this);
        }

        return $this;
    }

    public function removeUserResponse(UserResponse $userResponse): static
    {
        if ($this->userResponses->removeElement($userResponse)) {
            // set the owning side to null (unless already changed)
            if ($userResponse->getQuestion() === $this) {
                $userResponse->setQuestion(null);
            }
        }

        return $this;
    }
}
