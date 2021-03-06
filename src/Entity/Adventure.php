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

    /**
     * Function that increases the food level.
     *
     * @param int $food Food to plus.
     *
     * @return self
     */
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

    /**
     * Function that reduces the food level.
     *
     * @param int $food Food to reduce.
     *
     * @return self
     */
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

    /**
     * Function that takes life depending on what
     * room that was entered.
     *
     * @param int $id Roomnumber.
     *
     * @return void
     */
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

    /**
     * Function that sets the picked up stuff, and returns
     * a message of what has been done.
     *
     * @param string $action Word to lookup.
     *
     * @return string
     */
    public function pickUpStuff(string $action): string
    {
        if (strpos($action, "Plocka upp bananerna") !== false) {
            $this->setBanana(1);
            return "Bananerna ligger i din ryggs??ck!";
        }

        if (strpos($action, "Plocka upp snigeln") !== false) {
            $this->setSnail(1);
            return "Snigeln ligger i din ryggs??ck!";
        }

        if (strpos($action, "Plocka upp drycken") !== false) {
            $this->setPotion(1);
            return "Drycken ligger i din ryggs??ck!";
        }

        if (strpos($action, "Plocka upp nyckeln") !== false) {
            $this->setKeys(1);
            return "Nyckeln ligger i din ryggs??ck!";
        }

        return "";
    }

    /**
     * Function that takes the thrown stuff away from the
     * backpack, and returns a message of what happened.
     *
     * @param string $action Word to lookup.
     *
     * @return string
     */
    public function throwStuff(string $action): string
    {
        if (strpos($action, "Kasta en banan") !== false) {
            $this->setBanana(0);
            return "Du har kastat bananerna ??t apan. Apan ger dig en sm??ll  
                        innan han tar bananerna och g??r iv??g.";
        }

        if (strpos($action, "Kasta en snigel") !== false) {
            $this->setSnail(0);
            return "Bl??ckfisken kramar om dig med alla sina armar innan den 
                        uppt??cker snigeln du kastat ??t honom. Bl??ckfisken sl??pper dig f??r att ??njuta   
                        en snigelm??ltid.";
        }
        return "";
    }

    /**
     * Function that gives lives or/and food
     * and returns a message.
     *
     * @param string $action Word to lookup.
     *
     * @return string
     */
    public function drinkEat(string $action): string
    {
        if (strpos($action, "Drick drycken") !== false) {
            $this->setPotion(0);
            $this->setLife(100);
            $this->setFood(100);
            return "Drycken ??r uppdrucken!";
        }

        if (strpos($action, "??t en banan") !== false) {
            $this->setBanana(0);
            $this->eat(40);
            return "Bananerna ??r upp??tna!";
        }
        return "";
    }

    /**
     * Function that returns a message depending on
     * if it was the monkey och octopus that
     * was fighting back.
     *
     * @param string $action Word to lookup.
     *
     * @return string
     */
    public function fighting(string $action): string
    {
        if (strpos($action, "Sl??ss mot apan") !== false) {
            return "Apan hoppar p?? dig f??r att ge igen! Du h??ller p?? att bli skadad.";
        }

        if (strpos($action, "Sl??ss mot bl??ckfisken") !== false) {
            return "Bl??ckfisken ger sig p?? dig f??r att skydda sitt bo!  
            Du h??ller p?? att bli allvarligt skadad.";
        }
        return "";
    }
}
