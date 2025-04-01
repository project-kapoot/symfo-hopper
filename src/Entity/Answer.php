<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $isCorrect = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Question $question = null;

    /**
     * @var Collection<int, UserResponse>
     */
    #[ORM\ManyToMany(targetEntity: UserResponse::class, inversedBy: 'answers')]
    private Collection $userResponse;

    public function __construct()
    {
        $this->userResponse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function isCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): static
    {
        $this->isCorrect = $isCorrect;

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
     * @return Collection<int, UserResponse>
     */
    public function getUserResponse(): Collection
    {
        return $this->userResponse;
    }

    public function addUserResponse(UserResponse $userResponse): static
    {
        if (!$this->userResponse->contains($userResponse)) {
            $this->userResponse->add($userResponse);
        }

        return $this;
    }

    public function removeUserResponse(UserResponse $userResponse): static
    {
        $this->userResponse->removeElement($userResponse);

        return $this;
    }
}
