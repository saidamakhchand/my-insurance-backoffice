<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
#[ApiResource]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEffet = null; // changed to camelCase

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $frequencePrix = null; // changed to camelCase

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'devis')]
    private ?Client $client = null;

    #[ORM\ManyToMany(targetEntity: Voiture::class, inversedBy: 'devis')]
    private Collection $voitures;

    public function __construct()
    {
        $this->voitures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDateEffet(): ?\DateTimeInterface
    {
        return $this->dateEffet; // changed to camelCase
    }

    public function setDateEffet(\DateTimeInterface $dateEffet): static // changed to camelCase
    {
        $this->dateEffet = $dateEffet;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getFrequencePrix(): ?string
    {
        return $this->frequencePrix; // changed to camelCase
    }

    public function setFrequencePrix(string $frequencePrix): static // changed to camelCase
    {
        $this->frequencePrix = $frequencePrix;

        return $this;
    }

    // Methods for Client relationship
    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    // Methods for Voiture relationship
    /**
     * @return Collection<int, Voiture>
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(Voiture $voiture): static
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures[] = $voiture;
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): static
    {
        $this->voitures->removeElement($voiture);

        return $this;
    }
}
