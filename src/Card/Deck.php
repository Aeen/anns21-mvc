<?php

namespace App\Card;

class Deck
{
    /**
     * A deck of cards
     */
    protected array $deck;
    private $color = array("♥", "♣", "♦", "♠");
    private $value = array("A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K");

    public function __construct()
    {
        $colorCount = count($this->color);
        $valueCount = count($this->value);

        $this->deck = [];
        for ($i = 0; $i < $colorCount; $i++) {
            for ($j = 0; $j < $valueCount; $j++) {
                array_push($this->deck, new Card($this->color[$i], $this->value[$j]));
            }
        }
    }

    public function getCards()
    {
        return $this->deck;
    }

    public function drawCard()
    {
        $card = array_shift($this->deck);

        return $card;
    }

    public function shuffleDeck()
    {
        return shuffle($this->deck);
    }
}
