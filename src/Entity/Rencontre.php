<?php

namespace App\Entity; 
use App\Repository\RencontreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Rencontre
 *
 * @ORM\Table(name="rencontre")
 * @ORM\Entity(repositoryClass=RencontreRepository::class)
 */
class Rencontre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="ID_Ren")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Type_Rencontre", type="string", length=0, nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter le Type de la rencontre")
     * @Groups("post:read")
     */
    private $typeRencontre;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_Invitation", type="string", length=50, nullable=false)
     * @Groups("post:read")
     */
    private $urlInvitation; 

    /**
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
    public function getIdEvent(): ?Evenement
    {
        return $this->ID_Event;
    }

    public function setIdEvent(?Evenement $idEvent): self
    {
        $this->ID_Event = $idEvent;

        return $this;
    }
}
