<?php

namespace App\Entity;

use App\Repository\SignatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignatureRepository::class)]
class Signature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    private ?string $fonctionSignataire = null;

    #[ORM\Column]
    private ?\DateTime $dateSignature = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getFonctionSignataire(): ?string
    {
        return $this->fonctionSignataire;
    }

    public function setFonctionSignataire(string $fonctionSignataire): static
    {
        $this->fonctionSignataire = $fonctionSignataire;

        return $this;
    }

    public function getDateSignature(): ?\DateTime
    {
        return $this->dateSignature;
    }

    public function setDateSignature(\DateTime $dateSignature): static
    {
        $this->dateSignature = $dateSignature;

        return $this;
    }
}
