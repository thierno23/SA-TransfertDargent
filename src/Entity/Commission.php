<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommissionRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"commission:read"}},
 * 
 *    collectionOperations={
 *  "get"={"access_control"="is_granted('ROLE_AdminSystem')"}
 *},
 *    itemOperations={
 *      "get"={"access_control"="is_granted('ROLE_AdminSystem')"},
 *      "put"={"access_control"="is_granted('ROLE_AdminSystem')"}
 *}
 * )
 * @ORM\Entity(repositoryClass=CommissionRepository::class)
 */
class Commission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"commission:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"commission:read"})
     */
    private $commissionEtat;

    /**
     * @ORM\Column(type="float")
     * @Groups({"commission:read"})
     */
    private $commissionSystem;

    /**
     * @ORM\Column(type="float")
     * @Groups({"commission:read"})
     */
    private $commissionEnvoie;

    /**
     * @ORM\Column(type="float")
     * @Groups({"commission:read"})
     */
    private $commissionRetrait;

    /**
     * @ORM\Column(type="float")
     * @Groups({"commission:read"})
     */
    private $commissionAgence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommissionEtat(): ?float
    {
        return $this->commissionEtat;
    }

    public function setCommissionEtat(float $commissionEtat): self
    {
        $this->commissionEtat = $commissionEtat;

        return $this;
    }

    public function getCommissionSystem(): ?float
    {
        return $this->commissionSystem;
    }

    public function setCommissionSystem(float $commissionSystem): self
    {
        $this->commissionSystem = $commissionSystem;

        return $this;
    }

    public function getCommissionEnvoie(): ?float
    {
        return $this->commissionEnvoie;
    }

    public function setCommissionEnvoie(float $commissionEnvoie): self
    {
        $this->commissionEnvoie = $commissionEnvoie;

        return $this;
    }

    public function getCommissionRetrait(): ?float
    {
        return $this->commissionRetrait;
    }

    public function setCommissionRetrait(float $commissionRetrait): self
    {
        $this->commissionRetrait = $commissionRetrait;

        return $this;
    }

    public function getCommissionAgence(): ?float
    {
        return $this->commissionAgence;
    }

    public function setCommissionAgence(float $commissionAgence): self
    {
        $this->commissionAgence = $commissionAgence;

        return $this;
    }
}
