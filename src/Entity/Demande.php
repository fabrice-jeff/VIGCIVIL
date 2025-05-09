<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroActe = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateSoumission = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(length: 255)]
    private ?string $copiePdf = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateTraitement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieuTraitement = null;

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

    public function getNumeroActe(): ?string
    {
        return $this->numeroActe;
    }

    public function setNumeroActe(string $numeroActe): static
    {
        $this->numeroActe = $numeroActe;

        return $this;
    }

    public function getDateSoumission(): ?\DateTime
    {
        return $this->dateSoumission;
    }

    public function setDateSoumission(?\DateTime $dateSoumission): static
    {
        $this->dateSoumission = $dateSoumission;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCopiePdf(): ?string
    {
        return $this->copiePdf;
    }

    public function setCopiePdf(string $copiePdf): static
    {
        $this->copiePdf = $copiePdf;

        return $this;
    }

    public function getDateTraitement(): ?\DateTime
    {
        return $this->dateTraitement;
    }

    public function setDateTraitement(?\DateTime $dateTraitement): static
    {
        $this->dateTraitement = $dateTraitement;

        return $this;
    }

    public function getLieuTraitement(): ?string
    {
        return $this->lieuTraitement;
    }

    public function setLieuTraitement(?string $lieuTraitement): static
    {
        $this->lieuTraitement = $lieuTraitement;

        return $this;
    }
}
