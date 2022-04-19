<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SalleCinemaRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SalleCinema
 *
 * @ORM\Table(name="salle_cinema", indexes={@ORM\Index(name="cinema_event", columns={"ID_Event"})})
 * @ORM\Entity(repositoryClass=SalleCinemaRepository::class)
 */
class SalleCinema
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Salle", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSalle;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Salle", type="string", length=50, nullable=false)
     *@Assert\NotBlank(message="Veuillez ajouter le nom de la salle")

     */
    private $nomSalle;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_Film", type="string", length=50, nullable=false)
     */
    private $urlFilm;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_Salle", type="string", length=50, nullable=false)
     */
    private $urlSalle;

    /**
     * @var string
     *
     * @ORM\Column(name="Chat", type="text", length=0, nullable=false)
     */
    private $chat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement", inversedBy="sallescinema")
     * @ORM\JoinColumn(name="ID_Event", referencedColumnName="ID_Event")
     */
    private $ID_Event;

    public function getIdSalle(): ?int
    {
        return $this->idSalle;
    }

    public function getNomSalle(): ?string
    {
        return $this->nomSalle;
    }

    public function setNomSalle(string $nomSalle): self
    {
        $this->nomSalle = $nomSalle;

        return $this;
    }

    public function getUrlFilm(): ?string
    {
        return $this->urlFilm;
    }

    public function setUrlFilm(string $urlFilm): self
    {
        $this->urlFilm = $urlFilm;

        return $this;
    }

    public function getUrlSalle(): ?string
    {
        return $this->urlSalle;
    }

    public function setUrlSalle(string $urlSalle): self
    {
        $this->urlSalle = $urlSalle;

        return $this;
    }

    public function getChat(): ?string
    {
        return $this->chat;
    }

    public function setChat(string $chat): self
    {
        $this->chat = $chat;

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
