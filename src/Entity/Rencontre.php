<?php

namespace App\Entity;
<<<<<<< HEAD

use Doctrine\ORM\Mapping as ORM;

/**
 * Rencontre
 *
 * @ORM\Table(name="rencontre", indexes={@ORM\Index(name="rencontre_event", columns={"ID_Event"})})
=======
use App\Repository\RencontreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Rencontre
 *
 * @ORM\Table(name="rencontre")
 * @ORM\Entity(repositoryClass=RencontreRepository::class)
>>>>>>> origin/master
 */
class Rencontre
{
    /**
<<<<<<< HEAD
     * @var int
     *
     * @ORM\Column(name="ID_Ren", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRen;
=======
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="ID_Ren")
     */
    private $id;
>>>>>>> origin/master

    /**
     * @var string
     *
     * @ORM\Column(name="Type_Rencontre", type="string", length=0, nullable=false)
<<<<<<< HEAD
=======
     * @Assert\NotBlank(message="Veuillez ajouter le Type de la rencontre")
>>>>>>> origin/master
     */
    private $typeRencontre;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_Invitation", type="string", length=50, nullable=false)
     */
    private $urlInvitation;

    /**
<<<<<<< HEAD
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Event", referencedColumnName="ID_Event")
     * })
     */
    private $idEvent;

    public function getIdRen(): ?int
    {
        return $this->idRen;
=======
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement", inversedBy="rencontres")
     * @ORM\JoinColumn(name="ID_Event", referencedColumnName="ID_Event")
     */
    private $ID_Event;

    public function getEvenement(): ?Evenement
    {
        return $this->ID_Event;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->ID_Event = $evenement;

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
>>>>>>> origin/master
    }

    public function getTypeRencontre(): ?string
    {
        return $this->typeRencontre;
    }

    public function setTypeRencontre(string $typeRencontre): self
    {
        $this->typeRencontre = $typeRencontre;

        return $this;
    }

    public function getUrlInvitation(): ?string
    {
        return $this->urlInvitation;
    }

    public function setUrlInvitation(string $urlInvitation): self
    {
        $this->urlInvitation = $urlInvitation;

        return $this;
    }

<<<<<<< HEAD
    public function getIdEvent(): ?Evenement
    {
        return $this->idEvent;
    }

    public function setIdEvent(?Evenement $idEvent): self
    {
        $this->idEvent = $idEvent;

        return $this;
    }


}
=======
}
>>>>>>> origin/master
