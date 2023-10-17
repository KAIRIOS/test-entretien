<?php

namespace App\Entity\DemandeClinique;

use App\Repository\DemandeClinique\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 * @ORM\Table(name="demande_clinique_reponses")
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=Depot::class, inversedBy="reponses")
     */
    private $depot;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="datetime", name="validated_at", nullable=true)
     */
    private ?\DateTime $validatedAt = null;

    /**
     * @ORM\Column(type="text", name="validation_reason", nullable=true)
     */
    private ?string $validationReason = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDepot(): ?Depot
    {
        return $this->depot;
    }

    public function setDepot(?Depot $depot): self
    {
        $this->depot = $depot;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getValidatedAt(): ?\DateTime
    {
        return $this->validatedAt;
    }

    /**
     * @param \DateTime $validatedAt
     * @return $this
     */
    public function setValidatedAt(\DateTime $validatedAt): self
    {
        $this->validatedAt = $validatedAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValidationReason(): ?string
    {
        return $this->validationReason;
    }

    /**
     * @param null $validationReason
     */
    public function setValidationReason($validationReason): self
    {
        $this->validationReason = $validationReason;

        return $this;
    }
}
