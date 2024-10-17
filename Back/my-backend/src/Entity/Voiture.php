<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
#[ApiResource]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroImmatriculation = null; // تغيرت إلى camelCase

    #[ORM\Column(length: 255)]
    private ?string $sage = null;

    #[ORM\Column(length: 255)]
    private ?string $emplacement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAchat = null; // تغيرت إلى camelCase

    #[ORM\ManyToMany(targetEntity: Devis::class, mappedBy: 'voitures')]
    private Collection $devis;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroImmatriculation(): ?string
    {
        return $this->numeroImmatriculation; // تغيرت إلى camelCase
    }

    public function setNumeroImmatriculation(string $numeroImmatriculation): static // تغيرت إلى camelCase
    {
        $this->numeroImmatriculation = $numeroImmatriculation;

        return $this;
    }

    public function getSage(): ?string
    {
        return $this->sage;
    }

    public function setSage(string $sage): static
    {
        $this->sage = $sage;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): static
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->dateAchat; // تغيرت إلى camelCase
    }

    public function setDateAchat(\DateTimeInterface $dateAchat): static // تغيرت إلى camelCase
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    // Methods for Devis relationship
    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): static
    {
        if (!$this->devis->contains($devi)) {
            $this->devis[] = $devi;
            $devi->addVoiture($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): static
    {
        if ($this->devis->removeElement($devi)) {
            $devi->removeVoiture($this);
        }

        return $this;
    }
}
