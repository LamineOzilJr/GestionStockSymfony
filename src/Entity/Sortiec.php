<?php

namespace App\Entity;

use App\Repository\SortiecRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SortiecRepository::class)]
class Sortiec
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateS;

    #[ORM\Column(type: 'decimal', precision: 10, scale: '0')]
    private $qtS;

    #[ORM\Column(type: 'string', length: 200)]
    private $categorie;

    #[ORM\ManyToOne(targetEntity: Produitc::class, inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private $produit;

    #[ORM\ManyToOne(targetEntity: Boutique::class, inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private $boutique;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sorties')]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateS(): ?\DateTimeInterface
    {
        return $this->dateS;
    }

    public function setDateS(\DateTimeInterface $dateS): self
    {
        $this->dateS = $dateS;

        return $this;
    }

    public function getQtS(): ?string
    {
        return $this->qtS;
    }

    public function setQtS(string $qtS): self
    {
        $this->qtS = $qtS;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getProduit(): ?Produitc
    {
        return $this->produit;
    }

    public function setProduit(?Produitc $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getBoutique(): ?Boutique
    {
        return $this->boutique;
    }

    public function setBoutique(?Boutique $boutique): self
    {
        $this->boutique = $boutique;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
