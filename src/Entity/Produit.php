<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    private $libelle;

    #[ORM\Column(type: 'string', length: 200)]
    private $categorie;

    #[ORM\Column(type: 'decimal', precision: 10, scale: '0')]
    private $qtStock;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Entree::class, orphanRemoval: true)]
    private $entrees;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Sortie::class, orphanRemoval: true)]
    private $sorties;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'produits')]
    private $user;

    public function __construct()
    {
        $this->entrees = new ArrayCollection();
        $this->sorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }


    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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


    public function getQtStock(): ?string
    {
        return $this->qtStock;
    }

    public function setQtStock(string $qtStock): self
    {
        $this->qtStock = $qtStock;

        return $this;
    }

    /**
     * @return Collection|Entree[]
     */
    public function getEntrees(): Collection
    {
        return $this->entrees;
    }

    public function addEntree(Entree $entree): self
    {
        if (!$this->entrees->contains($entree)) {
            $this->entrees[] = $entree;
            $entree->setProduit($this);
        }

        return $this;
    }

    public function removeEntree(Entree $entree): self
    {
        if ($this->entrees->removeElement($entree)) {
            // set the owning side to null (unless already changed)
            if ($entree->getProduit() === $this) {
                $entree->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties[] = $sorty;
            $sorty->setProduit($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): self
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getProduit() === $this) {
                $sorty->setProduit(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->libelle;
        return $this->categorie;
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
