<?php

namespace App\Entity;
<<<<<<< HEAD

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="user_event", columns={"ID_Utilisateur"})})
 * @ORM\Entity
=======
use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Evenement
 *
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
>>>>>>> origin/master
 */
class Evenement
{
    /**
<<<<<<< HEAD
     * @var int
     *
     * @ORM\Column(name="ID_Event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvent;
=======
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="ID_Event")
     */
    private $id;
>>>>>>> origin/master

    /**
     * @var string
     *
<<<<<<< HEAD
     * @ORM\Column(name="Nom_Event", type="string", length=50, nullable=false)
=======
     * @ORM\Column(name="Nom_Event", type="string", nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter le nom")
     * @Assert\Length(min=2,
     *     max=15,
     *     maxMessage="Le nom de l'événement doit êter inférieur à 15",
     *     minMessage ="Le nom de l'événement doit être supérieur à 2"
     * )
>>>>>>> origin/master
     */
    private $nomEvent;

    /**
     * @var int
     *
     * @ORM\Column(name="Nbr_participants", type="integer", nullable=false)
<<<<<<< HEAD
=======
     * @Assert\NotBlank(message="Veuillez ajouter le nombre de participants")
     * @Assert\Length(max=2,
     *                maxMessage="Le nombre de participants ne dépasse passe pas les deux chiffres"
     * )
>>>>>>> origin/master
     */
    private $nbrParticipants;

    /**
     * @var string
     *
     * @ORM\Column(name="Date_Event", type="string", length=50, nullable=false)
<<<<<<< HEAD
=======
     * @Assert\LessThanOrEqual("today", message="Veuillez choisir une date convenable")
>>>>>>> origin/master
     */
    private $dateEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="Type_Event", type="string", length=0, nullable=false)
<<<<<<< HEAD
=======
     * @Assert\NotBlank(message="Veuillez choisir le type de l'evenement")
>>>>>>> origin/master
     */
    private $typeEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="Event_Visibilite", type="string", length=0, nullable=false)
<<<<<<< HEAD
=======
     * @Assert\NotBlank(message="Veuillez choisir la visivilité de l'evenement")
>>>>>>> origin/master
     */
    private $eventVisibilite;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=50, nullable=false)
<<<<<<< HEAD
=======
     *@Assert\NotBlank(message="Veuillez ajouter une description de l'evenement")
>>>>>>> origin/master
     */
    private $description;

    /**
<<<<<<< HEAD
     * @var string
     *
     * @ORM\Column(name="Date_P", type="string", length=50, nullable=false)
     */
    private $dateP;

    /**
     * @var string
     *
     * @ORM\Column(name="Liste_Utilisateur", type="text", length=0, nullable=false)
     */
    private $listeUtilisateur;
=======
     *
     * @ORM\Column(name="Date_P", type="datetime", nullable=false)
     *  @Assert\DateTime(message="type invalid")
     * @var string A "Y-m-d H:i:s" formatted value,
     *
     *
     */
    private $dateP;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rencontre", mappedBy="evenement")
     */
    private $rencontres;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SalleCinema",mappedBy="evenement")
     */
    private $salleCinema;
>>>>>>> origin/master

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Utilisateur", referencedColumnName="ID_Utilisateur")
     * })
     */
    private $idUtilisateur;

<<<<<<< HEAD
    public function getIdEvent(): ?int
    {
        return $this->idEvent;
    }

=======
>>>>>>> origin/master
    public function getNomEvent(): ?string
    {
        return $this->nomEvent;
    }

    public function setNomEvent(string $nomEvent): self
    {
        $this->nomEvent = $nomEvent;

        return $this;
    }

    public function getNbrParticipants(): ?int
    {
        return $this->nbrParticipants;
    }

    public function setNbrParticipants(int $nbrParticipants): self
    {
        $this->nbrParticipants = $nbrParticipants;

        return $this;
    }

    public function getDateEvent(): ?string
    {
        return $this->dateEvent;
    }

    public function setDateEvent(string $dateEvent): self
    {
<<<<<<< HEAD
=======

>>>>>>> origin/master
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getTypeEvent(): ?string
    {
        return $this->typeEvent;
    }

    public function setTypeEvent(string $typeEvent): self
    {
        $this->typeEvent = $typeEvent;

        return $this;
    }

    public function getEventVisibilite(): ?string
    {
        return $this->eventVisibilite;
    }

    public function setEventVisibilite(string $eventVisibilite): self
    {
        $this->eventVisibilite = $eventVisibilite;

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

<<<<<<< HEAD
    public function getDateP(): ?string
=======
    public function getDateP()
>>>>>>> origin/master
    {
        return $this->dateP;
    }

<<<<<<< HEAD
    public function setDateP(string $dateP): self
=======
    public function setDateP($dateP)
>>>>>>> origin/master
    {
        $this->dateP = $dateP;

        return $this;
    }

<<<<<<< HEAD
    public function getListeUtilisateur(): ?string
    {
        return $this->listeUtilisateur;
    }

    public function setListeUtilisateur(string $listeUtilisateur): self
    {
        $this->listeUtilisateur = $listeUtilisateur;
=======
    public function getIdUtilisateur(): ?Utilisateurs
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateurs $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;
>>>>>>> origin/master

        return $this;
    }

<<<<<<< HEAD
    public function getIdUtilisateur(): ?Utilisateurs
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateurs $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }


}
=======
    public function __construct()
    {
        $this->rencontres=new ArrayCollection();
        $this->salleCinema=new ArrayCollection();
    }
    public function getRencontres(): Collection
    {
        return $this->rencontres;
    }
    public function removeRencontre(Rencontre $rencontre){
        if($this->rencontres->removeElement($rencontre)){
            if($rencontre->getIdEvent()===$this){
                $rencontre->setIdEvent(null);
            }
        }
    }
    public function addRencontre(Rencontre $rencontre){
        $this->rencontres[]=$rencontre;
        return $this;
    }

    public function getSallesCinema(): Collection
    {
        return $this->salleCinema;
    }
    public function removeSalleCinema(SalleCinema $salleCinema){
        if($this->salleCinema->removeElement($salleCinema)){
            if($salleCinema->getIdEvent()===$this){
                $salleCinema->setIdEvent(null);
            }
        }
    }
    public function addSalleCinema(Rencontre $salleCinema){
        $this->salleCinema[]=$salleCinema;
        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
}
>>>>>>> origin/master
