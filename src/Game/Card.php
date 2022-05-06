<?php

namespace App\Game;

class Card
{
    /**
     * Describes a card
     */
    private string $color;
    private string $value;

    public function __construct(string $color, string $value)
    {
        $this->color = $color;
        $this->value = $value;
    }

    public function getDetails(): array
    {
        return [$this->color, $this->value];
    }

    public function toString(): string
    {
        return $this->color . " " . $this->value;
    }

    public function getValueOfCard()
    {
        if (strtolower($this->value) === 'a') {
            $value = 11; // @TODO An Ace can be either 1 or 11; player choice
        } else {
            $value = is_numeric($this->value) ? $this->value : 10;
        }
        
        return $value;
        
    }

    public function getTypeOfCard(): string
    {
        return $this->value;
    }
}
