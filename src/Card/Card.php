<?php

namespace App\Card;

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
}
