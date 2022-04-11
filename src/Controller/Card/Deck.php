<?php

namespace App\Card;

 use App\Card\Card;
 use App\Card\Deck;
 use App\Card\DeckWith2Jokers;
 use App\Card\Player;

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
        $this->deck = [];
        for ($i = 0; $i < count($this->color); $i++) {
            for ($j = 0; $j < count($this->value); $j++) {
                array_push($this->deck, new Card($this->color[$i], $this->value[$j]));
            }
        }
    }

    public function get_cards()
    {
        return $this->deck;
    }

    public function draw_card()
    {
        $card = array_shift($this->deck);
        
        return $card;
    }

    public function shuffle_deck()
    {
        return shuffle($this->deck);
    }

}
