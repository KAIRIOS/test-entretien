<?php

namespace App\Entity\DemandeClinique;

use App\Repository\DemandeClinique\ReponseWorkflowLogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseWorkflowLogRepository::class)
 * @ORM\Table(name="demande_clinique_reponse_workflow_logs")
 */
class ReponseWorkflowLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Reponse::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $reponse;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $transition;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getReponse(): Reponse
    {
        return $this->reponse;
    }

    public function setReponse(Reponse $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getTransition(): string
    {
        return $this->transition;
    }

    public function setTransition(string $transition): self
    {
        $this->transition = $transition;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
