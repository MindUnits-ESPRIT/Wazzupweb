<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="message_collab", columns={"ID_Collab"}), @ORM\Index(name="message_user", columns={"ID_Uitlisateur"})})
 * @ORM\Entity
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", length=65535, nullable=false)
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Uitlisateur", referencedColumnName="ID_Utilisateur")
     * })
     */
    private $idUitlisateur;

    /**
     * @var \SalleCollaboration
     *
     * @ORM\ManyToOne(targetEntity="SalleCollaboration")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Collab", referencedColumnName="ID_Collab")
     * })
     */
    private $idCollab;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdUitlisateur(): ?Utilisateurs
    {
        return $this->idUitlisateur;
    }

    public function setIdUitlisateur(?Utilisateurs $idUitlisateur): self
    {
        $this->idUitlisateur = $idUitlisateur;

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
