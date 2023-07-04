<?php

namespace App\Entity;

use App\Repository\BarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BarRepository::class)]
class Bar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToOne(mappedBy: 'bar', cascade: ['persist', 'remove'])]
    private ?Foo $foo = null;

    #[ORM\OneToMany(mappedBy: 'bar', targetEntity: Baz::class, cascade: ['persist', 'remove'])]
    private Collection $bazs;

    public function __construct()
    {
        $this->bazs = new ArrayCollection();
    }

    public function __clone()
    {
        $this->id = null;
        $this->bazs = new ArrayCollection();
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

    public function getFoo(): ?Foo
    {
        return $this->foo;
    }

    public function setFoo(?Foo $foo): static
    {
        $this->foo = $foo;

        return $this;
    }

    /**
     * @return Collection<int, Baz>
     */
    public function getBazs(): Collection
    {
        return $this->bazs;
    }

    public function addBaz(Baz $baz): static
    {
        if (!$this->bazs->contains($baz)) {
            $this->bazs->add($baz);
            $baz->setBar($this);
        }

        return $this;
    }

    public function removeBaz(Baz $baz): static
    {
        if ($this->bazs->removeElement($baz)) {
            // set the owning side to null (unless already changed)
            if ($baz->getBar() === $this) {
                $baz->setBar(null);
            }
        }

        return $this;
    }
}
