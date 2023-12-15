<?php

namespace App\Entity\DemandeClinique;

use App\Repository\DemandeClinique\ReponseRepository;
use DateTimeInterface;
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
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $titre;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=Depot::class, inversedBy="reponses")
     */
    private ?Depot $depot;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $estValidee;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $raisonValidation;

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

    public function getDateCreation(): ?DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(DateTimeInterface $dateCreation): self
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

    public function estValidee(): ?bool
    {
        return $this->estValidee;
    }

    public function setEstValidee(bool $estValidee): self
    {
        $this->estValidee = $estValidee;

        return $this;
    }

    public function getRaisonValidation(): ?string
    {
        return $this->raisonValidation;
    }

    public function setRaisonValidation(?string $raisonValidation): self
    {
        $this->raisonValidation = $raisonValidation;

        return $this;
    }
}
