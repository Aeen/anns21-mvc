<?php

namespace App\Card;

class DeckWith2Jokers extends Deck
{
    /**
     * A deck of cards
     */
    protected array $deck;

    public function __construct()
    {
        parent::__construct();

        array_push($this->deck, new Card("🃏", "Joker"));
        array_push($this->deck, new Card("🃏", "Joker"));
    }
}
