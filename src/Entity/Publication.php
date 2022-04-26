<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Publication
 * @Vich\Uploadable
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
     * @ORM\Column(name="Fichier", type="string", length=150, nullable=true)
     */
    private $fichier;

    /**
<<<<<<< HEAD
     * @var string|null
     *
     * @ORM\Column(name="Visibilite", type="string", length=10, nullable=true)
=======
     * @var int
     *
     * @ORM\Column(name="Nbr_Signal", type="integer", nullable=false)
>>>>>>> dc3bee45d75999f724829ad96c6cb2340bf005f9
     */
    private $nbrSignal = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Liste_Signal", type="text", length=0, nullable=true)
     */
    private $listeSignal;

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

    public function setFichier(?string $fichier): self
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

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="posts", fileNameProperty="fichier")
     *
     * @var File|null
     */
    private $imageFile;



    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->datePublication = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

}
