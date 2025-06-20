<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    use EntityUserOperation;
    use EntityTimestampableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateSoumission = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateTraitement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieuTraitement = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ActeEtatCivil $numeroActe = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

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


    public function getDateSoumission(): ?\DateTime
    {
        return $this->dateSoumission;
    }

    public function setDateSoumission(?\DateTime $dateSoumission): static
    {
        $this->dateSoumission = $dateSoumission;

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

    public function getNumeroActe(): ?ActeEtatCivil
    {
        return $this->numeroActe;
    }

    public function setNumeroActe(?ActeEtatCivil $numeroActe): static
    {
        $this->numeroActe = $numeroActe;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }
}
