<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull] // تأكد من إضافة هذا للتحقق من القيمة
    private ?\DateTimeInterface $dateNaissance = null; // تاريخ الميلاد

    #[ORM\Column]
    private ?bool $estPersonne = null; // true = شخص، false = مهني

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Devis::class, cascade: ['persist', 'remove'])]
    private Collection $devis;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Voiture::class, cascade: ['persist', 'remove'])]
    private Collection $voitures;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
        $this->voitures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    public function isEstPersonne(): ?bool
    {
        return $this->estPersonne;
    }

    public function setEstPersonne(bool $estPersonne): static
    {
        $this->estPersonne = $estPersonne;
        return $this;
    }

    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevis(Devis $devis): static
    {
        if (!$this->devis->contains($devis)) {
            $this->devis[] = $devis;
            $devis->setClient($this);
        }
        return $this;
    }

    public function removeDevis(Devis $devis): static
    {
        if ($this->devis->removeElement($devis)) {
            if ($devis->getClient() === $this) {
                $devis->setClient(null);
            }
        }
        return $this;
    }

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
            $voiture->setClient($this);
        }
        return $this;
    }

    public function removeVoiture(Voiture $voiture): static
    {
        if ($this->voitures->removeElement($voiture)) {
            if ($voiture->getClient() === $this) {
                $voiture->setClient(null);
            }
        }
        return $this;
    }
}
