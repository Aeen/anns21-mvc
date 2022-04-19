<?php

namespace App\Game;

class Player
{
    protected string $type; // Either player or dealer
    protected array $currentHand; // Array of Card objects representing cards in player's hand
    protected int $currentScore; // Sum of card values in player's hand

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

    public function clearCurrentHand(): void
    {
        $this->currentHand = [];
        $this->currentScore = 0;
    }

    public function getCurrentHand(): array
    {
        return $this->currentHand;
    }

    public function setCurrentHand(Card $card): void
    {
        $this->currentHand[] = $card;
    }

    public function setCurrentScore(Card $pulledCard): void
    {
        $this->currentScore += $pulledCard->getValueOfCard();
    }

    public function setCurrentScoreNum($num): void
    {
        $this->currentScore = $num;
    }

    public function getCurrentScore(): int
    {
        return $this->currentScore;
    }

    // public static function getPlayer(string $type = 'player'): string
    // {
    //     return $type;
    // }

    public function getPlayer(): string
    {
        return $this->type;
    }
}
