<?php

namespace App\Entity;

use App\Repository\BoutiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoutiqueRepository::class)]
class Boutique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $Adresse;

    // #[ORM\OneToMany(mappedBy: 'boutique', targetEntity: Entreec::class, orphanRemoval: true)]
    // private $entrees;

    #[ORM\OneToMany(mappedBy: 'boutique', targetEntity: Sortiec::class, orphanRemoval: true)]
    private $sorties;

    public function __construct()
    {
      //  $this->entrees = new ArrayCollection();
        $this->sorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

      /**
     * @return Collection|Sortiec[]
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortiec $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties[] = $sorty;
            $sorty->setBoutique($this);
        }

        return $this;
    }

    public function removeSorty(Sortiec $sorty): self
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getBoutique() === $this) {
                $sorty->setBoutique(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->Nom;
        
    }
}
