<?php

namespace App\Entity;

use App\Repository\EntreefRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntreefRepository::class)]
class Entreef
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateE;

    #[ORM\Column(type: 'decimal', precision: 10, scale: '0')]
    private $qtE;

    #[ORM\Column(type: 'string')]
    private $categorie;

    #[ORM\ManyToOne(targetEntity: Produitf::class, inversedBy: 'entreefs')]
    #[ORM\JoinColumn(nullable: false)]
    private $produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDateE(): ?\DateTimeInterface
    {
        return $this->dateE;
    }

    public function setDateE(\DateTimeInterface $dateE): self
    {
        $this->dateE = $dateE;

        return $this;
    }

    public function getQtE(): ?string
    {
        return $this->qtE;
    }

    public function setQtE(string $qtE): self
    {
        $this->qtE = $qtE;

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

    public function getProduit(): ?Produitf
    {
        return $this->produit;
    }

    public function setProduit(?Produitf $produit): self
    {
        $this->produit = $produit;

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
