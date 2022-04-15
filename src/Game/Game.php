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
        $this->deck = $deck;
        $this->player = $player;
        $this->dealer = $dealer;
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

        $pulledCard = $this->deck->drawCard();
        $this->dealer->setCurrentHand($pulledCard);
        $this->dealer->setCurrentScore($pulledCard);
    }

    public function hit()
    {
        $pulledCard = $this->deck->drawCard();
        $this->player->setCurrentHand($pulledCard);
        $this->player->setCurrentScore($pulledCard);
    }

    public function dealerHit()
    {
        $currentScore = $this->dealer->getCurrentScore();

        if ($currentScore < 17) {
            $pulledCard = $this->deck->drawCard();
            $this->dealer->setCurrentHand($pulledCard);
            $this->dealer->setCurrentScore($pulledCard);
        }
    }

    public function checkForWinner()
    {
        $dealersCurrentScore = $this->dealer->getCurrentScore();
        $playersCurrentScore = $this->player->getCurrentScore();

        if (
            $dealersCurrentScore === 17 && $playersCurrentScore === 17
            || $dealersCurrentScore === 18 && $playersCurrentScore === 18
            || $dealersCurrentScore === 19 && $playersCurrentScore === 19
        ) {
            return 'Dealer won';
        } elseif (
            $dealersCurrentScore === 20 && $playersCurrentScore === 20
            || $dealersCurrentScore === 21 && $playersCurrentScore === 21
        ) {
            return 'Shared first place';
        } elseif ($dealersCurrentScore > 17 && $dealersCurrentScore > $playersCurrentScore)
        {
            return 'Dealer won';
        } elseif ($playersCurrentScore > 17 && $playersCurrentScore > $dealersCurrentScore)
        {
            return 'Player won';
        }

        return '';
    }
}
