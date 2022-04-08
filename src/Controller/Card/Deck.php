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

    /*     public function __construct()
    {
        $this->deck = $deck;

        for ($i = 0; $this->count($color); $i++) {
            for ($j = 0; $this->count($value); $j++) {
                array_push($this->deck, new App/Card/Card($i, $j));
            }
        }

    } */

    public function __construct()
    {
        $this->deck = [];
        for ($i = 0; $i < count($this->color); $i++) {
            for ($j = 0; $j < count($this->value); $j++) {
                array_push($this->deck, new Card($this->color[$i], $this->value[$j]));
            }
        }
    }




    /*
    private array $deck = [];
    private array $color = [];
    private array $value = []; */

    /*     public function __construct()
    {
        $this->deck = array();
        $this->color = array("♣", "♦", "♥", "♠");
        $this->value = array("A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K");

        for ($i = 0; $i < count($this->color); $i++) {
            for ($j = 0; $i < count($this->value); $j++) {
                array_push($this->deck, new App/Card/Card($i, $j));
            }
        }
    } */


    public function get_cards()
    {
        return $this->deck;
    }
}
