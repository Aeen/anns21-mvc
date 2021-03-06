<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 20)]
    private $isbn;

    #[ORM\Column(type: 'string', length: 255)]
    private $author;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $picture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPictureMap(?string $picture): self
    {
        if ($picture === null) {
            $this->picture = "img/bildlös.jpg";
            return $this;
        }

        if (strpos($picture, 'img/') !== false) {
            $this->picture = $picture;
        } else {
            $this->picture = "img/" . $picture;
        }

        return $this;
    }

    public function setPictureEnd(?string $picture): self
    {
        if ($picture === null) {
            $this->picture = "img/bildlös.jpg";
            return $this;
        }

        if (strpos($picture, '.') !== false) {
            $this->picture = $picture;
        } else {
            $this->picture = $picture . '.jpg';
        }

        return $this;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
