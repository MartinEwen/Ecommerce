<?php

namespace App\Entity;

use App\Repository\GammeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GammeRepository::class)]
class Gamme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nameGamme = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameGamme(): ?string
    {
        return $this->nameGamme;
    }

    public function setNameGamme(string $nameGamme): static
    {
        $this->nameGamme = $nameGamme;

        return $this;
    }
}
