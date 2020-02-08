<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="note")
 * @ORM\Entity
 */
class Note
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
     * @var float
     *
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=false)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Module", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etudiant", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etudiant;

    /**
     * @ORM\Column(type="integer")
     */
    private $absence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }
public function __toString() {
    return $this->name;
}
public function getAbsence(): ?int
{
    return $this->absence;
}

public function setAbsence(int $absence): self
{
    $this->absence = $absence;
    return $this;
}

}
