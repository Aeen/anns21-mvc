<?php

namespace App\Entity;

use App\Repository\AdventureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdventureRepository::class)]
class Adventure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $life;

    #[ORM\Column(type: 'integer')]
    private $food;

    #[ORM\Column(type: 'integer')]
    private $snail;

    #[ORM\Column(type: 'integer')]
    private $banana;

    #[ORM\Column(type: 'integer')]
    private $keys;

    #[ORM\Column(type: 'integer')]
    private $potion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLife(): ?int
    {
        return $this->life;
    }

    public function setLife(int $life): self
    {
        $this->life = $life;

        return $this;
    }


    public function eat(int $food): self
    {
        if ($this->food + $food > 100) {
            $this->food = 100;
        } else {
            $this->food = $this->food + $food;
        }
        return $this;
    }

    public function fight(int $life): self
    {
        $this->life = $this->life - $life;

        return $this;
    }

    public function getFood(): ?int
    {
        return $this->food;
    }

    public function setFood(int $food): self
    {
        $this->food = $food;

        return $this;
    }

    public function getHungry(int $food): self
    {
        $this->food = $this->food - $food;

        return $this;
    }

    public function getSnail(): ?int
    {
        return $this->snail;
    }

    public function setSnail(int $snail): self
    {
        $this->snail = $snail;

        return $this;
    }

    public function getBanana(): ?int
    {
        return $this->banana;
    }

    public function setBanana(int $banana): self
    {
        $this->banana = $banana;

        return $this;
    }

    public function getKeys(): ?int
    {
        return $this->keys;
    }

    public function setKeys(int $keys): self
    {
        $this->keys = $keys;

        return $this;
    }

    public function getPotion(): ?int
    {
        return $this->potion;
    }

    public function setPotion(int $potion): self
    {
        $this->potion = $potion;

        return $this;
    }

    public function reduceLife(int $id): void
    {
        if ($id === 3) {
            $this->fight(25);
        }

        if ($id === 9) {
            $this->fight(40);
        }

        if ($id === 10) {
            $this->fight(40);
        }

    }
}
