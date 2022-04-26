<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication", indexes={@ORM\Index(name="Id_Utilisateur_INDEX", columns={"Id_Utilisateur"})})
 * @ORM\Entity
 */
class Publication
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Publication", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPublication;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Fichier", type="string", length=150, nullable=false)
     */
    private $fichier;

    /**
     * @var int
     *
     * @ORM\Column(name="Nbr_Signal", type="integer", nullable=false)
     */
    private $nbrSignal = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Liste_Signal", type="text", length=0, nullable=true)
     */
    private $listeSignal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Publication", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datePublication = 'CURRENT_TIMESTAMP';

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Utilisateur", referencedColumnName="ID_Utilisateur")
     * })
     */
    private $idUtilisateur;

    public function getIdPublication(): ?int
    {
        return $this->idPublication;
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

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getNbrSignal(): ?int
    {
        return $this->nbrSignal;
    }

    public function setNbrSignal(int $nbrSignal): self
    {
        $this->nbrSignal = $nbrSignal;

        return $this;
    }

    public function getListeSignal(): ?string
    {
        return $this->listeSignal;
    }

    public function setListeSignal(?string $listeSignal): self
    {
        $this->listeSignal = $listeSignal;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

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
