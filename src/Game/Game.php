<?php

namespace App\Game;

class Game
{
    public const BLACKJACK = 21; // The final score in Blackjack
    private Deck $deck;
    private Player $player;
    private Player $dealer;

    public function __construct($deck, $player, $dealer)
    {
        // $session->set("deck", Deck::shuffleDeck());

        // $session->set("player", new Player());
        // $session->set("dealer", new Player('dealer'));

        // $deck = Deck::shuffleDeck();
        // $player = new Player();
        // $dealer = new Player('dealer');

        $this->deck = $deck;
        $this->player = $player;
        $this->dealer = $dealer;

        //self::new();
    }

    public function start()
    {
        $this->deck->shuffleDeck();

        $pulledCard = $this->deck->drawCard();
        $this->player->setCurrentHand($pulledCard);
        $this->player->setCurrentScore($pulledCard);

        $pulledCard = $this->deck->drawCard();
        $this->dealer->setCurrentHand($pulledCard);
        $this->dealer->setCurrentScore($pulledCard);

        $pulledCard = $this->deck->drawCard();
        $this->player->setCurrentHand($pulledCard);
        $this->player->setCurrentScore($pulledCard);

        // $pulledCard = $this->deck->drawCard();
        // $this->dealer->setCurrentHand($pulledCard);
        // $this->dealer->setCurrentScore($pulledCard);
    }

 
}
