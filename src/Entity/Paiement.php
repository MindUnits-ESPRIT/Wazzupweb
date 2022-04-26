<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @var DateTime
     *
     * @ORM\Column(name="Date_paiement", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     * @var \DateTime|null
     */
    private $datePaiement = 'new \DateTime()';

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Choisissez une methode paiement valide")
     * @ORM\Column(name="Methode_paiement", type="string", length=0, nullable=false)
     */
    private $methodePaiement;

    /**
     * @var float|null
    /**
     * @Assert\GreaterThan(
     *     value = 5,
     *     message ="Prix doit etre >5$"
     * )
     *@Assert\NotBlank(message="Prix doit etre non vide")
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    public function __construct()
    {
        $this->datePaiement = new \DateTime();
    }

    public function getIdPaiement(): ?int
    {
        return $this->idPaiement;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(?\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;
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


}
