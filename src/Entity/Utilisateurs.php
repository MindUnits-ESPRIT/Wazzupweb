<?php

namespace App\Entity;

use Serializable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\UtilisateursRepository;
/**
 * Utilisateurs
 *
 * @ORM\Table(name="utilisateurs")
 * @UniqueEntity(
 *     fields={"email"},
 *     groups={"registration"},
 *     message="Votre email est déja utilisé"
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateursRepository")
 
* @UniqueEntity(
    *     fields={"email"},
    *     groups={"forgotpassword"},
    *     message="Email trouvé"
    * )
    * @ORM\Entity(repositoryClass="App\Repository\UtilisateursRepository")
    */

class Utilisateurs implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Utilisateur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUtilisateur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=30)
     * @Assert\NotBlank(message="Veuillez insérer votre nom")
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenom", type="string", length=30)
     * @Assert\NotBlank(message="Veuillez insérer votre prenom")     */
    private $prenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="datenaissance", type="string", length=30, nullable=true)
     * @Assert\NotBlank(message="Veuillez insérer votre date de naissance ")
     */
    private $datenaissance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="genre", type="string", length=0, nullable=true)
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="num_tel", type="string", length=12, nullable=false)
     * @Assert\NotBlank(message="Veuillez insérer votre numero de telephone ")
     */
    private $numTel;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Veuillez insérer votre email ")
     * @Assert\Email(
     *     message = "Votre email '{{ value }}' n'est pas un email valide."
     * )
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avatar", type="string", length=200, nullable=true)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=220, nullable=false)-
     * @Assert\NotBlank(message="Veuillez insérer votre mot de passe ")
     * @Assert\NotCompromisedPassword(message="Veuillez choisir un mot de passe plus fort")
     * @Assert\Regex(pattern="/^(?=.*[a-z])(?=.*\d).{6,}$/i", message="Votre mot de passe doit comporter au moins 6 caractères et inclure au moins une lettre et un chiffre.")
     * @Assert\EqualTo(propertyPath="mdpconfirm",message="Votre mot de passe ne correspond pas a votre confirmation")
     *
     */
    private $mdp;
    /**
     * @Assert\EqualTo(propertyPath="mdpconfirm",message="Votre mot de passe doit etre le meme que le mot de passe saisie précedement")
     */

    public $mdpconfirm;

    /**
     * @var string
     *
     * @ORM\Column(name="type_user", type="string", length=0, nullable=false, options={"default"="User"})
     */
    private $typeUser = 'User';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="passwordRequestedAt", type="datetime", nullable=true)
     */
    private $passwordrequestedat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Token", type="string", length=200, nullable=true)
     */
    private $token;

    /**
     * @var bool
     *
     * @ORM\Column(name="activated", type="boolean", nullable=false)
     */
    private $activated = 'false';

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbsignal", type="integer", nullable=true)
     */
    private $nbsignal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="evaluation", type="integer", nullable=true)
     */
    private $evaluation;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="sponsor", type="boolean", nullable=true)
     */
    private $sponsor = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="desactivated", type="boolean", nullable=true)
     */
    private $desactivated = '0';

    /**
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     * @var \DateTime|null
     */
    private $creationDate = 'new \DateTime()';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SalleCollaboration", mappedBy="idUtlisateur")
     */
    private $idCollab;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime();
        $this->idCollab = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function setIdUtilisateur(?int $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }
    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
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

    public function getDatenaissance(): ?string
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(object $datenaissance = null): self
    {
        if (!($datenaissance == null)) {
            $this->datenaissance = $datenaissance->format('d-m-Y');
        }

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getTypeUser(): ?string
    {
        return $this->typeUser;
    }

    public function setTypeUser(string $typeUser): self
    {
        $this->typeUser = $typeUser;

        return $this;
    }

    public function getPasswordrequestedat(): ?\DateTimeInterface
    {
        return $this->passwordrequestedat;
    }

    public function setPasswordrequestedat(
        ?\DateTimeInterface $passwordrequestedat
    ): self {
        $this->passwordrequestedat = $passwordrequestedat;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getActivated(): ?bool
    {
        return $this->activated;
    }

    public function setActivated(bool $activated): self
    {
        $this->activated = $activated;

        return $this;
    }

    public function getNbsignal(): ?int
    {
        return $this->nbsignal;
    }

    public function setNbsignal(?int $nbsignal): self
    {
        $this->nbsignal = $nbsignal;

        return $this;
    }

    public function getEvaluation(): ?int
    {
        return $this->evaluation;
    }

    public function setEvaluation(?int $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getSponsor(): ?bool
    {
        return $this->sponsor;
    }

    public function setSponsor(?bool $sponsor): self
    {
        $this->sponsor = $sponsor;

        return $this;
    }

    public function getDesactivated(): ?bool
    {
        return $this->desactivated;
    }

    public function setDesactivated(?bool $desactivated): self
    {
        $this->desactivated = $desactivated;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection<int, SalleCollaboration>
     */
    public function getIdCollab(): Collection
    {
        return $this->idCollab;
    }

    public function addIdCollab(SalleCollaboration $idCollab): self
    {
        if (!$this->idCollab->contains($idCollab)) {
            $this->idCollab[] = $idCollab;
            $idCollab->addIdUtlisateur($this);
        }

        return $this;
    }

    public function removeIdCollab(SalleCollaboration $idCollab): self
    {
        if ($this->idCollab->removeElement($idCollab)) {
            $idCollab->removeIdUtlisateur($this);
        }

        return $this;
    }
    public function eraseCredentials()
    {
    }
    public function getSalt()
    {
    }
    public function getRoles()
    {
        return ['ROLE_USER'];
    }
    public function getPassword()
    {
    }
    public function getUsername()
    {
    }
}
