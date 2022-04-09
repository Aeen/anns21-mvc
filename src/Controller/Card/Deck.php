<?php

namespace App\Card;

//  use App\Card\Card;
//  use App\Card\Deck;
//  use App\Card\Player;
//  use App\Card\CardHand;

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

    // public function deal_cards(int $num, array $array) 
    // {
    //     $cardArray = [];

    //     for ($i = 0; $i < $num; $i++) {
    //         array_push($cardArray, array_shift($array));
    //     }

    //     return $cardArray;
    // }

}
