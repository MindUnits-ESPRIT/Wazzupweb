<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Interets
 *
 * @ORM\Table(name="interets", indexes={@ORM\Index(name="id_utilisateur", columns={"ID_Utilisateur"})})
 * @ORM\Entity(repositoryClass="App\Repository\InteretsRepository")
 */
class Interets
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_interet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idInteret;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_interet", type="string", length=0, nullable=false)
     */
    private $nomInteret;

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Utilisateur", referencedColumnName="ID_Utilisateur")
     * })
     */
    private $idUtilisateur;

    public function getIdInteret(): ?int
    {
        return $this->idInteret;
    }

    public function getNomInteret(): ?string
    {
        return $this->nomInteret;
    }

    public function setNomInteret(string $nomInteret): self
    {
        $this->nomInteret = $nomInteret;

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
