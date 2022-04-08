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

    public function get_details(): array
    {
        return [$this->color, $this->value];
    }

    public function to_string(): string
    {
        return $this->color . " " . $this->value;
    }
}
