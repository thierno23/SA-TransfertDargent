<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TableauFraisRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"tableauFrais:read"}},
 * 
 *    collectionOperations={
 *  "get"={"access_control"="is_granted('ROLE_AdminSystem')"}
 *},
 *    itemOperations={
 *      "get"={"access_control"="is_granted('ROLE_AdminSystem')"},
 *      "put"={"access_control"="is_granted('ROLE_AdminSystem')"}
 *}
 * )
 * @ORM\Entity(repositoryClass=TableauFraisRepository::class)
 */
class TableauFrais
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tableauFrais:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"tableauFrais:read"})
     */
    private $min;

    /**
     * @ORM\Column(type="float")
     * @Groups({"tableauFrais:read"})
     */
    private $max;

    /**
     * @ORM\Column(type="float")
     * @Groups({"tableauFrais:read"})
     */
    private $tarif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMin(): ?float
    {
        return $this->min;
    }

    public function setMin(float $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function getMax(): ?float
    {
        return $this->max;
    }

    public function setMax(float $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }
}
