<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Publication
 *
 * @ORM\Table(name="publication", indexes={@ORM\Index(name="Id_Utilisateur_INDEX", columns={"Id_Utilisateur"})})
 * @ORM\Entity(repositoryClass=App\Repository\PublicationRepository::class)
 *
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
     *@Assert\Length(min=2,
     *     max=255,
     *     maxMessage="Vous avez dépasser 255 lettres",
     *      minMessage ="écrivez plus que 2 lettres"
     *    )
     * @ORM\Column(name="Description", type="string", length=150, nullable=false)
     * @Assert\NotBlank(message="Veuillez écrivez quelque chose !")
     *
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Fichier", type="string", length=150, nullable=false)
     */
    private $fichier;

    /**
     * @var string
     *
     * @ORM\Column(name="Visibilite", type="string", length=0, nullable=false, options={"default"="True"})
     */
    private $visibilite = 'True';

    /**
     * @var int
     *
     * @ORM\Column(name="Priority", type="integer", nullable=false, options={"default"="1"})
     */
    private $priority = 1;

    /**
     * @Assert\DateTime
     * @var \DateTime|null
     * @ORM\Column(name="Date_Publication", type="datetime", nullable=false)
     */
    private $datePublication;

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

    public function getVisibilite(): ?string
    {
        return $this->visibilite;
    }

    public function setVisibilite(string $visibilite): self
    {
        $this->visibilite = $visibilite;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getDatePublication():?\DateTime
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTime $datePublication): self
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
