<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * SalleCollaboration
 *
 * @ORM\Table(name="salle_collaboration", indexes={@ORM\Index(name="ID_Utilisateur", columns={"ID_Utilisateur"})})
 *   @UniqueEntity(
 *     fields={"nomCollab"},
 *     groups={"deletet"},
 *     message="Votre Collab existe déja"
 * )
 * * @ORM\Entity(repositoryClass="App\Repository\SalleCollabRepository")
 */
class SalleCollaboration
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Collab", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCollab;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Collab", type="string", length=20, nullable=false)
     * @Assert\NotBlank( groups={"deletet"},message="Veuillez choisir un nom ")
     *  @Assert\EqualTo(groups={"deletec"},propertyPath="nomconfirm",message="nom ne correspond pas")
     
     */
    private $nomCollab;

    /**
     * @var string
     * @Assert\EqualTo(groups={"deletec"}, propertyPath="nomconfirm",message="nom doit etre le meme que le nom du collab a supprimer")
     */
    private $nomconfirm;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_Collab", type="string", length=60, nullable=false)

     */
    private $urlCollab;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Chat", type="text", length=0, nullable=true)
    

     */
    private $chat;

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Utilisateur", referencedColumnName="ID_Utilisateur")
     * })
     */
    private $idUtilisateur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Utilisateurs", inversedBy="idCollab")
     * @ORM\JoinTable(name="collab_members",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_Collab", referencedColumnName="ID_Collab")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_Utlisateur", referencedColumnName="ID_Utilisateur")
     *   }
     * )
     */
    private $idUtlisateur;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idUtlisateur = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdCollab(): ?int
    {
        return $this->idCollab;
    }

    public function getNomCollab(): ?string
    {
        return $this->nomCollab;
    }

    public function setNomCollab(string $nomCollab): self
    {
        $this->nomCollab = $nomCollab;

        return $this;
    }
    public function getnomconfirm(): ?string
    {
        return $this->nomconfirm;
    }

    public function setnomconfirm(string $nomconfirm): self
    {
        $this->nomconfirm = $nomconfirm;

        return $this;
    }

    public function getUrlCollab(): ?string
    {
        return $this->urlCollab;
    }

    public function setUrlCollab(string $urlCollab): self
    {
        $this->urlCollab = $urlCollab;

        return $this;
    }

    public function getChat(): ?string
    {
        return $this->chat;
    }

    public function setChat(?string $chat): self
    {
        $this->chat = $chat;

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
     * @return Collection<int, Utilisateurs>
     */
    public function getIdUtlisateur(): Collection
    {
        return $this->idUtlisateur;
    }

    public function addIdUtlisateur(Utilisateurs $idUtlisateur): self
    {
        if (!$this->idUtlisateur->contains($idUtlisateur)) {
            $this->idUtlisateur[] = $idUtlisateur;
        }

        return $this;
    }

    public function removeIdUtlisateur(Utilisateurs $idUtlisateur): self
    {
        $this->idUtlisateur->removeElement($idUtlisateur);

        return $this;
    }
}
