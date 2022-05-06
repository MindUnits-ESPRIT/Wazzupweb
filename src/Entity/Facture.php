<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture", uniqueConstraints={@ORM\UniqueConstraint(name="num_fac", columns={"num_fac"})}, indexes={@ORM\Index(name="facture_user", columns={"ID_Utilisateur"}), @ORM\Index(name="facture_paiement", columns={"ID_paiement"}), @ORM\Index(name="facture_offre", columns={"id_offre"})})
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var int
     *
     * @ORM\Column(name="num_fac", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numFac;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_fac", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateFac = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     *
     * @ORM\Column(name="file", type="string", length=30, nullable=true)
     */
    private $file;

    /**
     * @var \Paiement
     *
     * @ORM\ManyToOne(targetEntity="Paiement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_paiement", referencedColumnName="ID_paiement")
     * })
     */
    private $idPaiement;

    /**
     * @var \OffrePublicitaire
     *
     * @ORM\ManyToOne(targetEntity="OffrePublicitaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_offre", referencedColumnName="id_offre")
     * })
     */
    private $idOffre;

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Utilisateur", referencedColumnName="ID_Utilisateur")
     * })
     */
    private $idUtilisateur;

    public function getNumFac(): ?int
    {
        return $this->numFac;
    }

    public function getDateFac(): ?\DateTimeInterface
    {
        return $this->dateFac;
    }

    public function setDateFac(\DateTimeInterface $dateFac): self
    {
        $this->dateFac = $dateFac;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getIdPaiement(): ?Paiement
    {
        return $this->idPaiement;
    }

    public function setIdPaiement(?Paiement $idPaiement): self
    {
        $this->idPaiement = $idPaiement;

        return $this;
    }

    public function getIdOffre(): ?OffrePublicitaire
    {
        return $this->idOffre;
    }

    public function setIdOffre(?OffrePublicitaire $idOffre): self
    {
        $this->idOffre = $idOffre;

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
