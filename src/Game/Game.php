<?php

namespace App\Game;

class Game
{
    private $deck;
    private $player;
    private $dealer;
    private string $stand;

    public function __construct($deck, $player, $dealer, string $stand = 'play')
    {
        $this->deck = $deck;
        $this->player = $player;
        $this->dealer = $dealer;
        $this->stand = $stand;
    }

    public function start(): void
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

    public function stand(): void
    {
        $this->stand = 'stand';
    }

    public function readStand(): string
    {
        return $this->stand;
    }

    public function hit(): void
    {
        if ($this->stand != 'stand') {
            $currentScore = $this->player->getCurrentScore();
            $dealerScore = $this->dealer->getCurrentScore();

            if ($currentScore < 21 && $dealerScore < 21) {
                $pulledCard = $this->deck->drawCard();
                $this->player->setCurrentHand($pulledCard);
                $this->player->setCurrentScore($pulledCard);
            }
        }
    }

    public function dealerHit(): void
    {
        $currentScore = $this->dealer->getCurrentScore();
        $playerScore = $this->player->getCurrentScore();

        if ($currentScore < 17 && $playerScore < 21) {
            $pulledCard = $this->deck->drawCard();
            $this->dealer->setCurrentHand($pulledCard);
            $this->dealer->setCurrentScore($pulledCard);
        }
    }

    public function checkForWinner(): string
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
        } elseif (
            $playersCurrentScore === 21
            && $dealersCurrentScore != 21
        ) {
            return 'BlackJack for player';
        } elseif (
            $dealersCurrentScore === 21
            && $playersCurrentScore != 21
        ) {
            return 'BlackJack for dealer';
        } elseif (
            $playersCurrentScore <= 21
            && $dealersCurrentScore > 21
        ) {
            return 'Player won';
        } elseif (
            $dealersCurrentScore <= 21
            && $playersCurrentScore > 21
        ) {
            return 'Dealer won';
        } elseif (
            $dealersCurrentScore > 17
            && $dealersCurrentScore <= 21
            && $dealersCurrentScore > $playersCurrentScore
            && ($playersCurrentScore >= 17 || $this->stand === 'stand')
        ) {
            return 'Dealer won';
        } elseif (
            $playersCurrentScore > 17
            && $playersCurrentScore <= 21
            && $playersCurrentScore > $dealersCurrentScore
            && $dealersCurrentScore >= 17
        ) {
            return 'Player won';
        } elseif (
            $playersCurrentScore > 21
            && $dealersCurrentScore > 21
        ) {
            return 'Both lost';
        }

        return '';
    }

    public function checkForWinnerWhilePlaying(): string
    {
        $dealersCurrentScore = $this->dealer->getCurrentScore();
        $playersCurrentScore = $this->player->getCurrentScore();

        if (
            $dealersCurrentScore === 20 && $playersCurrentScore === 20
            || $dealersCurrentScore === 21 && $playersCurrentScore === 21
        ) {
            return 'Shared first place';
        } elseif (
            $playersCurrentScore === 21
            && $dealersCurrentScore != 21
        ) {
            return 'BlackJack for player';
        } elseif (
            $dealersCurrentScore === 21
            && $playersCurrentScore != 21
        ) {
            return 'BlackJack for dealer';
        } elseif (
            $playersCurrentScore <= 21
            && $dealersCurrentScore > 21
        ) {
            return 'Player won';
        } elseif (
            $dealersCurrentScore <= 21
            && $playersCurrentScore > 21
        ) {
            return 'Dealer won';
        } elseif (
            $playersCurrentScore > 21
            && $dealersCurrentScore > 21
        ) {
            return 'Both lost';
        }

        return '';
    }
}
