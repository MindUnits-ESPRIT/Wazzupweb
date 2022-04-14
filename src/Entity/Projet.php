<?php

namespace App\Entity;
use App\Repository\ProjetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Projet
 *
 * @ORM\Table(name="projet", indexes={@ORM\Index(name="ID_Collab", columns={"ID_Collab"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
 */
class Projet
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Projet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProjet;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Projet", type="string", length=20, nullable=false)
     */
    private $nomProjet;

    /**
     * @var string
     *
     * @ORM\Column(name="Description_Projet", type="string", length=800, nullable=false)
     */
    private $descriptionProjet;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_trello", type="string", length=60, nullable=false)
     */
    private $urlTrello;

    /**
     * @var \SalleCollaboration
     *
     * @ORM\ManyToOne(targetEntity="SalleCollaboration")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Collab", referencedColumnName="ID_Collab")
     * })
     */
    private $idCollab;

    public function getIdProjet(): ?int
    {
        return $this->idProjet;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): self
    {
        $this->nomProjet = $nomProjet;

        return $this;
    }

    public function getDescriptionProjet(): ?string
    {
        return $this->descriptionProjet;
    }

    public function setDescriptionProjet(string $descriptionProjet): self
    {
        $this->descriptionProjet = $descriptionProjet;

        return $this;
    }

    public function getUrlTrello(): ?string
    {
        return $this->urlTrello;
    }

    public function setUrlTrello(string $urlTrello): self
    {
        $this->urlTrello = $urlTrello;

        return $this;
    }

    public function getIdCollab(): ?SalleCollaboration
    {
        return $this->idCollab;
    }

    public function setIdCollab(?SalleCollaboration $idCollab): self
    {
        $this->idCollab = $idCollab;

        return $this;
    }
}
