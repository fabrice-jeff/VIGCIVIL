<?php

namespace App\Entity;

use App\Repository\ActeEtatCivilRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActeEtatCivilRepository::class)]
class ActeEtatCivil
{
    use EntityUserOperation;
    use EntityTimestampableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroActe = null;

    #[ORM\Column(length: 255)]
    private ?string $prenoms = null;

    #[ORM\Column]
    private ?\DateTime $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPere = null;

    #[ORM\Column(length: 255)]
    private ?string $nomMere = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $copiePdf = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeActe $TypeActe = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): static
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTime $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(string $lieuNaissance): static
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getNomPere(): ?string
    {
        return $this->nomPere;
    }

    public function setNomPere(string $nomPere): static
    {
        $this->nomPere = $nomPere;

        return $this;
    }

    public function getNomMere(): ?string
    {
        return $this->nomMere;
    }

    public function setNomMere(string $nomMere): static
    {
        $this->nomMere = $nomMere;

        return $this;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getTypeActe(): ?TypeActe
    {
        return $this->TypeActe;
    }

    public function setTypeActe(?TypeActe $TypeActe): static
    {
        $this->TypeActe = $TypeActe;

        return $this;
    }
}
