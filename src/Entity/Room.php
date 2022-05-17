<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $blur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $back;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $forward1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $forward2;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $action1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $action2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBlur(): ?string
    {
        return $this->blur;
    }

    public function setBlur(string $blur): self
    {
        $this->blur = $blur;

        return $this;
    }

    public function getBack(): ?string
    {
        return $this->back;
    }

    public function setBack(?string $back): self
    {
        $this->back = $back;

        return $this;
    }

    public function getForward1(): ?string
    {
        return $this->forward1;
    }

    public function setForward1(?string $forward1): self
    {
        $this->forward1 = $forward1;

        return $this;
    }

    public function getForward2(): ?string
    {
        return $this->forward2;
    }

    public function setForward2(?string $forward2): self
    {
        $this->forward2 = $forward2;

        return $this;
    }

    public function getAction1(): ?string
    {
        return $this->action1;
    }

    public function setAction1(?string $action1): self
    {
        $this->action1 = $action1;

        return $this;
    }

    public function getAction2(): ?string
    {
        return $this->action2;
    }

    public function setAction2(?string $action2): self
    {
        $this->action2 = $action2;

        return $this;
    }
}
