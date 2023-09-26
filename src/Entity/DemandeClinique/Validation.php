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
	 * @ORM\OneToOne(targetEntity=Depot::class, inversedBy="validation", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $Depot;

	/**
	 * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="validation")
	 */
	private $responses;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $dateCreation;

	public function __construct()
	{
		$this->responses = new ArrayCollection();
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
		return $this->Depot;
	}

	public function setDepot(Depot $Depot): self
	{
		$this->Depot = $Depot;

		return $this;
	}

	/**
	 * @return Collection<int, Reponse>
	 */
	public function getResponses(): Collection
	{
		return $this->responses;
	}

	public function addResponse(Reponse $response): self
	{
		if (!$this->responses->contains($response)) {
			$this->responses[] = $response;
			$response->setValidation($this);
		}

		return $this;
	}

	public function removeResponse(Reponse $response): self
	{
		if ($this->responses->removeElement($response)) {
			// set the owning side to null (unless already changed)
			if ($response->getValidation() === $this) {
				$response->setValidation(null);
			}
		}

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
}
