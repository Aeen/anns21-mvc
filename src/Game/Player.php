<?php

namespace App\Game;

class Player
{
    //public const DEALERSTANDS = 17; // The mininum card value a dealer will stand on
    protected $type; // Either player or dealer
    protected $currentHand; // Array of Card objects representing cards in player's hand
    protected $currentScore; // Sum of card values in player's hand

    /**
    * Constructor
    */
    public function __construct(string $type = 'player')
    {
        if ($type !== 'player' && $type !== 'dealer') {
            throw new \Exception('Invalid player type.');
        }

        $this->type = $type;
        $this->currentHand = [];
        $this->currentScore = 0;
    }

    // public function hit(Card $cardForTesting = null)
    // {
    //     $pulledCard = $cardForTesting ?? Deck::drawCard();

    //     $this->currentHand[] = $pulledCard;
    //     $this->currentScore += $pulledCard->getValueOfCard();

    //     // Prevents busting on opening deal
    //     if (
    //         count($this->currentHand) === 2
    //         && strtolower($this->currentHand[0]->getTypeOfCard()) === 'a'
    //         && strtolower($this->currentHand[1]->getTypeOfCard()) === 'a'
    //     ) {
    //         $this->currentScore -= 10;
    //     }

    //     // @TODO This is not perfect- see Card::getValueOfCard()
    //     if (
    //         strtolower($pulledCard->getTypeOfCard()) === 'a'
    //         && $this->currentScore > Game::BLACKJACK
    //     ) {
    //         $this->currentScore -= 10;
    //     }

    //     if (!$cardForTesting) {
    //         $this->checkForPlayerBlackjack();
    //     }
    // }

    public function clearCurrentHand()
    {
        $this->currentHand = [];
        $this->currentScore = 0;
    }

    public function getCurrentHand()
    {
        return $this->currentHand;
    }

    public function setCurrentHand($card)
    {
        $this->currentHand[] = $card;
    }

    public function setCurrentScore($pulledCard)
    {
        $this->currentScore += $pulledCard->getValueOfCard();
    }

    public function getCurrentScore()
    {
        return $this->currentScore;
    }

    public static function getPlayer(string $type = 'player'): self
    {
        return $type;
    }

    // public function stand()
    // {
    //     Game::handOver();
    //     Game::checkForWinner();
    // }

    // public function checkForPlayerBlackjack()
    // {
    //     if (strtolower($this->type) === 'player' && $this->currentScore >= Game::BLACKJACK) {
    //         $this->stand();
    //     } else {
    //         Game::refresh();
    //     }
    // }
}
