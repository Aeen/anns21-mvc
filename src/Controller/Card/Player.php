<?php

namespace App\Card;

 use App\Card\Card;
 use App\Card\Deck;
 use App\Card\DeckWith2Jokers;
 use App\Card\Player;

class Player
{
    private array $player;

    public function __construct()
    {
        $this->player = [];
    }

}