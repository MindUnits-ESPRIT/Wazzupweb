<?php

namespace App\Entity;

use App\Repository\CollabMembersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="collab_members", indexes={@ORM\Index(name="ID_Collab", columns={"ID_Collab"})})
 * @ORM\Entity(repositoryClass=CollabMembersRepository::class)
 */
class CollabMembers
{
    /**
     
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id_collab;

    public function getid_collab(): ?int
    {
        return $this->id_collab;
    }
    public function setid_collab(int $id_collab): self
    {
        $this->id_collab = $id_collab;

        return $this;
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */

    private $ID_Utlisateur;

    public function getID_Utlisateur(): ?int
    {
        return $this->ID_Utlisateur;
    }
    public function setIdUtilisateur(int $idUtilisateur): self
    {
        $this->ID_Utlisateur = $idUtilisateur;

        return $this;
    }

    public function getIdCollab(): ?int
    {
        return $this->id_collab;
    }

    public function getIDUtlisateur(): ?int
    {
        return $this->ID_Utlisateur;
    }
}
