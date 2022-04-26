<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OffrePublicitaire
 *
 * @ORM\Table(name="offre_publicitaire", indexes={@ORM\Index(name="offre_user", columns={"ID_Utilisateur"})})
 * @ORM\Entity
 */
class OffrePublicitaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_offre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOffre;

    /**
     * @Assert\NotBlank(message="nomOffre doit etre non vide")
     * @var string|null
     *
     * @ORM\Column(name="nom_offre", type="string", length=30, nullable=true)
     */
    private $nomOffre;

    /**
     * @var string|null
     *@Assert\NotBlank(message="ContenuOffre doit etre non vide")
     * @ORM\Column(name="contenu_offre", type="text", length=65535, nullable=true)
     */
    private $contenuOffre;

    /**
     * @var int|null
     *@Assert\NotBlank(message="Durée doit etre non vide")
     * @ORM\Column(name="nbr_max_offre", type="integer", nullable=true)
     */
    private $nbrMaxOffre;

    /**
     *
     * @var \Utilisateurs
     *
     *@Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Utilisateur", referencedColumnName="ID_Utilisateur")
     * })
     */
    private $idUtilisateur;

    public function getIdOffre(): ?int
    {
        return $this->idOffre;
    }

    public function getNomOffre(): ?string
    {
        return $this->nomOffre;
    }

    public function setNomOffre(?string $nomOffre): self
    {
        $this->nomOffre = $nomOffre;

        return $this;
    }

    public function getContenuOffre(): ?string
    {
        return $this->contenuOffre;
    }

    public function setContenuOffre(?string $contenuOffre): self
    {
        $this->contenuOffre = $contenuOffre;

        return $this;
    }

    public function getNbrMaxOffre(): ?int
    {
        return $this->nbrMaxOffre;
    }

    public function setNbrMaxOffre(?int $nbrMaxOffre): self
    {
        $this->nbrMaxOffre = $nbrMaxOffre;

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
