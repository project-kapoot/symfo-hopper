<?php

namespace App\Entity;

use App\Repository\SessionQuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionQuizRepository::class)]
class SessionQuiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $Presenter = null;

    /**
     * @var Collection<int, user>
     */
    #[ORM\ManyToMany(targetEntity: user::class)]
    private Collection $Participants;

    #[ORM\ManyToOne]
    private ?Quiz $Quiz = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $atStarting = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $atEnding = null;

    public function __construct()
    {
        $this->Participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresenter(): ?user
    {
        return $this->Presenter;
    }

    public function setPresenter(?user $Presenter): static
    {
        $this->Presenter = $Presenter;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getParticipants(): Collection
    {
        return $this->Participants;
    }

    public function addParticipant(user $participant): static
    {
        if (!$this->Participants->contains($participant)) {
            $this->Participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(user $participant): static
    {
        $this->Participants->removeElement($participant);

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->Quiz;
    }

    public function setQuiz(?Quiz $Quiz): static
    {
        $this->Quiz = $Quiz;

        return $this;
    }

    public function getAtStarting(): ?\DateTimeInterface
    {
        return $this->atStarting;
    }

    public function setAtStarting(?\DateTimeInterface $atStarting): static
    {
        $this->atStarting = $atStarting;

        return $this;
    }

    public function getAtEnding(): ?\DateTimeInterface
    {
        return $this->atEnding;
    }

    public function setAtEnding(?\DateTimeInterface $atEnding): static
    {
        $this->atEnding = $atEnding;

        return $this;
    }
}
