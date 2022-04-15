<?php

namespace App\Game;

class Deck
{
    /**
     * A deck of cards
     */
    protected array $deck;
    private array $color = array("♥", "♣", "♦", "♠");
    private array $value = array("A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K");

    public function __construct()
    {
        $this->deck = [];
        for ($i = 0; $i < count($this->color); $i++) {
            for ($j = 0; $j < count($this->value); $j++) {
                array_push($this->deck, new Card($this->color[$i], $this->value[$j]));
            }
        }
    }

    public function getCards(): array
    {
        return $this->deck;
    }

    public function drawCard()
    {
        return array_shift($this->deck);
    }

    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }
}
