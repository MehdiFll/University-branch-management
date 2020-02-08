<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Filiere
 *
 * @ORM\Table(name="filiere")
 * @ORM\Entity
 */
class Filiere
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="annee_inscription", type="string", length=9, nullable=false)
     */
    private $anneeInscription;

    /**
     * @var string
     *
     * @ORM\Column(name="annee_fin", type="string", length=9, nullable=false)
     */
    private $anneeFin;

    /**
     * @var string
     *
     * @ORM\Column(name="semestre_courant", type="string", length=2, nullable=false)
     */
    private $semestreCourant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Module", mappedBy="filiere", orphanRemoval=true)
     */
    private $modules;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etudiant", mappedBy="filiere", orphanRemoval=true)
     */
    private $etudiants;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAnneeInscription(): ?string
    {
        return $this->anneeInscription;
    }

    public function setAnneeInscription(string $anneeInscription): self
    {
        $this->anneeInscription = $anneeInscription;

        return $this;
    }

    public function getAnneeFin(): ?string
    {
        return $this->anneeFin;
    }

    public function setAnneeFin(string $anneeFin): self
    {
        $this->anneeFin = $anneeFin;

        return $this;
    }

    public function getSemestreCourant(): ?string
    {
        return $this->semestreCourant;
    }

    public function setSemestreCourant(string $semestreCourant): self
    {
        $this->semestreCourant = $semestreCourant;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->setFiliere($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
            // set the owning side to null (unless already changed)
            if ($module->getFiliere() === $this) {
                $module->setFiliere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setFiliere($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->contains($etudiant)) {
            $this->etudiants->removeElement($etudiant);
            // set the owning side to null (unless already changed)
            if ($etudiant->getFiliere() === $this) {
                $etudiant->setFiliere(null);
            }
        }

        return $this;
    }

public function __toString() {
    return $this->nom." ".$this->anneeInscription;
}
}
