<?php

namespace App\Entity\DemandeClinique;

use App\Repository\DemandeClinique\ValidationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ValidationRepository::class)
 */
class Validation
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="text")
	 */
	private $raison;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $dateCreation;

	/**
	 * @ORM\OneToOne(targetEntity=Reponse::class, inversedBy="validation", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $reponse;

	/**
	 * @ORM\ManyToOne(targetEntity=Depot::class, inversedBy="validations")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $depot;



	public function __construct()
	{
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getRaison(): ?string
	{
		return $this->raison;
	}

	public function setRaison(string $raison): self
	{
		$this->raison = $raison;

		return $this;
	}

	public function getDepot(): ?Depot
	{
		return $this->depot;
	}

	public function setDepot(Depot $depot): self
	{
		$this->depot = $depot;

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

	public function getReponse(): ?Reponse
	{
		return $this->reponse;
	}

	public function setReponse(Reponse $reponse): self
	{
		$this->reponse = $reponse;

		return $this;
	}
}
