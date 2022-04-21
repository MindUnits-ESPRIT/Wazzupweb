<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PublicationSignaler
 *
 * @ORM\Table(name="publication_signaler", indexes={@ORM\Index(name="signaler_Foreign_pub", columns={"Id_publication"}), @ORM\Index(name="signaler_Foreign_uti", columns={"Id_utilisateur"})})
<<<<<<< HEAD
 * @ORM\Entity(repositoryClass=App\Repository\PublicationSignalerRepository::class)
=======
 * @ORM\Entity(repositoryClass="App\Repository\PublicationSignalerRepository")
>>>>>>> e08e18ccac08d8da5a91f92c513bcf0b24fa59d4
 */
class PublicationSignaler
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Signaler", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSignaler;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=0, nullable=false)
     */
    private $type;

    /**
     * @Assert\DateTime
     * @var \DateTime|null
     * @ORM\Column(name="Date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_utilisateur", referencedColumnName="ID_Utilisateur")
     * })
     */
    private $idUtilisateur;

    /**
     * @var \Publication
     *
     * @ORM\ManyToOne(targetEntity="Publication")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_publication", referencedColumnName="Id_Publication")
     * })
     */
    private $idPublication;

    public function getIdSignaler(): ?int
    {
        return $this->idSignaler;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDate():?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

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

    public function getIdPublication(): ?Publication
    {
        return $this->idPublication;
    }

    public function setIdPublication(?Publication $idPublication): self
    {
        $this->idPublication = $idPublication;

        return $this;
    }


}
