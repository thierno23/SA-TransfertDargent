<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asset;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"user:read"}},
 *    collectionOperations={
 *        "get"={"access_control"="is_granted('ROLE_AdminSystem')"},
 *        "get_caissier"={
 *          "method"="GET",
 *          "path"= "/users/caissier",
 *          "security"="is_granted('ROLE_AdminSystem')"
 *      },  
 *},
 *    itemOperations={
 *        "get"={"access_control"="is_granted('ROLE_AdminSystem') or object==user"},
 *         "delete"={"access_control"="is_granted('ROLE_AdminSystem')"}
 *})
 * @ApiFilter(SearchFilter::class, properties={"profil.libelle": "exact"})
 * @UniqueEntity("username", message="l'adress username doit être unique")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read","compte:read","transaction:read","depot:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"user:read","compte:write","compte:read","transaction:read","depot:read"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"user:read","compte:write","compte:read"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"user:read","compte:write","compte:read","transaction:read","depot:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"user:read","compte:write","compte:read","transaction:read","depot:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"user:read","compte:write","compte:read","transaction:read","depot:read"})
     */
    private $cni;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"user:read","compte:write","compte:read","transaction:read","depot:read"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"user:read","compte:write","compte:read","transaction:read","depot:read"})
     */
    private $address;

    /**
     * @ORM\Column(type="boolean")
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"user:read","compte:write","compte:read","transaction:read"})
     */
    private $statut = false;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Asset\NotBlank(message="Veuillez remplir ce champs")
     * @Groups({"user:read","compte:write","compte:read","transaction:read","depot:read"})
     */
    private $profil;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="users")
     * @Groups({"transaction:read"})
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="userDepot")
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="userDepot")
     */
    private $depots;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->depots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setUserDepot($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUserDepot() === $this) {
                $transaction->setUserDepot(null);
            }
        }

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
            $depot->setUserDepot($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getUserDepot() === $this) {
                $depot->setUserDepot(null);
            }
        }

        return $this;
    }
}
