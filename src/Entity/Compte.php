<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints as Asset;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 * denormalizationContext={"groups"={"compte:write"}},
 * normalizationContext={"groups"={"compte:read"}},
 * 
 *    collectionOperations={
 *        "get"={"access_control"="is_granted('ROLE_AdminSystem') or is_granted('ROLE_Caissier')"},
 *        "post"={"access_control"="is_granted('ROLE_AdminSystem')"}  
 *},
 *    itemOperations={
 *        "get"={"access_control"="is_granted('ROLE_AdminSystem')or is_granted('ROLE_Caissier')"},
 *         "delete"={"access_control"="is_granted('ROLE_AdminSystem')"}
 *})
 *
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 * @UniqueEntity("numeroCompte", message="l'adress username doit être unique")
 */
class Compte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"compte:read","transaction:read","depot:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"compte:write","compte:read","transaction:read","depot:read"})
     */
    private $numeroCompte;

    /**
     * @ORM\Column(type="float", precision=10, scale=0)
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Assert\GreaterThanOrEqual(
     *  value = 700000.00,
     *  message="initialiser le compte avec un dépôt d’au moins 700 mille"
     * )
     * @Groups({"compte:write","compte:read"})
     */
    private $montant ;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"compte:write","compte:read"})
     */
    private $statut = false;

    /**
     * @ORM\OneToOne(targetEntity=Agence::class, mappedBy="compte", cascade={"persist", "remove"})
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"compte:write","compte:read"})
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="compte", cascade={"persist", "remove"})
     */
    private $depots;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        // unset the owning side of the relation if necessary
        if ($agence === null && $this->agence !== null) {
            $this->agence->setCompte(null);
        }

        // set the owning side of the relation if necessary
        if ($agence !== null && $agence->getCompte() !== $this) {
            $agence->setCompte($this);
        }

        $this->agence = $agence;

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getCompte() === $this) {
                $depot->setCompte(null);
            }
        }

        return $this;
    }
}
