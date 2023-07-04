<?php

namespace App\Entity;

use App\Repository\FooRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FooRepository::class)]
class Foo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToOne(inversedBy: 'foo', cascade: ['persist', 'remove'])]
    private ?Bar $bar = null;

    public function __clone(): void
    {
        $this->id = null;
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
        // unset the owning side of the relation if necessary
        if ($bar === null && $this->bar !== null) {
            $this->bar->setFoo(null);
        }

        // set the owning side of the relation if necessary
        if ($bar !== null && $bar->getFoo() !== $this) {
            $bar->setFoo($this);
        }

        $this->bar = $bar;

        return $this;
    }
}
