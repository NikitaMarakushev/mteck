<?php

namespace App\Entity;

use App\Repository\HeaderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeaderRepository::class)]
class Header
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    private ?string $topCmnt = null;

    #[ORM\Column(length: 30)]
    private ?string $middleCmnt = null;

    #[ORM\Column(length: 30)]
    private ?string $lastCmnt = null;

    #[ORM\Column(length: 30)]
    private ?string $btnCmnt = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTopCmnt(): ?string
    {
        return $this->topCmnt;
    }

    public function setTopCmnt(string $topCmnt): self
    {
        $this->topCmnt = $topCmnt;

        return $this;
    }

    public function getMiddleCmnt(): ?string
    {
        return $this->middleCmnt;
    }

    public function setMiddleCmnt(string $middleCmnt): self
    {
        $this->middleCmnt = $middleCmnt;

        return $this;
    }

    public function getLastCmnt(): ?string
    {
        return $this->lastCmnt;
    }

    public function setLastCmnt(string $lastCmnt): self
    {
        $this->lastCmnt = $lastCmnt;

        return $this;
    }

    public function getBtnCmnt(): ?string
    {
        return $this->btnCmnt;
    }

    public function setBtnCmnt(string $btnCmnt): self
    {
        $this->btnCmnt = $btnCmnt;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }
}