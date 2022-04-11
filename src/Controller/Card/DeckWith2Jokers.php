<?php

namespace App\Card;

 use App\Card\Card;
 use App\Card\Deck;
 use App\Card\DeckWith2Jokers;
 use App\Card\Player;

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
