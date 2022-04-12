<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement")
 * @ORM\Entity
 */
class Paiement
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_paiement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPaiement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_paiement", type="datetime_immutable", nullable=true)
     */
    private $datePaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="Methode_paiement", type="string", length=0, nullable=false)
     */
    private $methodePaiement;

    /**
     * @var float|null
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    public function getIdPaiement(): ?int
    {
        return $this->idPaiement;
    }


    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(\DateTimeInterface $datePaiement)
    {
        $this->setDatePaiement(new \DateTime());

        return $this;
    }

    public function getMethodePaiement(): ?string
    {
        return $this->methodePaiement;
    }

    public function setMethodePaiement(string $methodePaiement): self
    {
        $this->methodePaiement = $methodePaiement;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
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

}
