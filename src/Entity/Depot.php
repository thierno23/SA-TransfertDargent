<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DepotRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Asset;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *  @ApiResource(
 *  normalizationContext={"groups"={"depot:read"}},
 * 
 *    collectionOperations={
 *    "get"={"access_control"="is_granted('ROLE_AdminSystem')"}
 *},
 *    itemOperations={
 *      "get"={"access_control"="is_granted('ROLE_AdminSystem')"},
 *}
 * )
 * @ORM\Entity(repositoryClass=DepotRepository::class)
 */
class Depot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"depot:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"depot:read"})
     * 
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="float")
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"depot:read"})
     */
    private $montantDepot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="depots")
     * @Groups({"depot:read"})
     */
    private $userDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="depots")
     * @Groups({"depot:read"})
     */
    private $compte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getMontantDepot(): ?float
    {
        return $this->montantDepot;
    }

    public function setMontantDepot(float $montantDepot): self
    {
        $this->montantDepot = $montantDepot;

        return $this;
    }

    public function getUserDepot(): ?User
    {
        return $this->userDepot;
    }

    public function setUserDepot(?User $userDepot): self
    {
        $this->userDepot = $userDepot;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
}
