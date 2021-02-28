<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asset;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 * denormalizationContext={"groups"={"agence:write"}},
 * normalizationContext={"groups"={"agence:read"}},
 * 
 *    collectionOperations={
 *        "get"={"access_control"="is_granted('ROLE_AdminSystem') or is_granted('ROLE_Caissier')"},
 *        "post"={"access_control"="is_granted('ROLE_AdminSystem')"}  
 *},
 *    itemOperations={
 *        "get"={"access_control"="is_granted('ROLE_AdminSystem') or is_granted('ROLE_Caissier')"},
 *         "delete"={"access_control"="is_granted('ROLE_AdminSystem')"}
 *})
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 * @UniqueEntity("nomAgence", message="l'adress username doit être unique")
 */
class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"compte:read","transaction:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"compte:write","compte:read","transaction:read"})
     */
    private $nomAgence;

    /**
     * @ORM\Column(type="float", precision=10, scale=0, nullable=true)
     * @Groups({"compte:write","compte:read"})
     */
    private $latittude;

    /**
     * @ORM\Column(type="float", precision=10, scale=0, nullable=true)
     * @Groups({"compte:write","compte:read"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"compte:write","compte:read"})
     */
    private $statut = false;

    /**
     * @ORM\OneToOne(targetEntity=Compte::class, inversedBy="agence", cascade={"persist", "remove"})
     * @Groups({"transaction:read"})
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="agence", cascade={"persist"})
     * @Groups({"compte:write","compte:read"})
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAgence(): ?string
    {
        return $this->nomAgence;
    }

    public function setNomAgence(string $nomAgence): self
    {
        $this->nomAgence = $nomAgence;

        return $this;
    }

    public function getLatittude(): ?string
    {
        return $this->latittude;
    }

    public function setLatittude(string $latittude): self
    {
        $this->latittude = $latittude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

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

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAgence($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAgence() === $this) {
                $user->setAgence(null);
            }
        }

        return $this;
    }
}
