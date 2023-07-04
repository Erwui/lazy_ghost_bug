<?php

namespace App\Entity;

use App\Repository\BazRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BazRepository::class)]
class Baz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'bazs')]
    private ?Bar $bar = null;

    public function __clone(): void
    {
        $this->id = null;
        $this->bar = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getBar(): ?Bar
    {
        return $this->bar;
    }

    public function setBar(?Bar $bar): static
    {
        $this->bar = $bar;

        return $this;
    }
}
