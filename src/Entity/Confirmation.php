<?php

namespace App\Entity;

use App\Repository\ConfirmationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfirmationRepository::class)]
class Confirmation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $credConf = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $credToken = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $credTime = null;

    public function isCredConf(): ?bool
    {
        return $this->credConf;
    }

    public function setCredConf(bool $credConf): self
    {
        $this->credConf = $credConf;

        return $this;
    }

    public function getCredToken(): ?string
    {
        return $this->credToken;
    }

    public function setCredToken(?string $credToken): self
    {
        $this->credToken = $credToken;

        return $this;
    }

    public function getCredTime(): ?\DateTimeInterface
    {
        return $this->credTime;
    }

    public function setCredTime(?\DateTimeInterface $credTime): self
    {
        $this->credTime = $credTime;

        return $this;
    }
}