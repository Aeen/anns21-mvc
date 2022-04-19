<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    public function testGetDetails(): void
    {
        $deck = new Deck;
        $cards = $deck->getCards();

        $test = $cards[0]->getDetails();
        $this->assertContains("♥", $test);
        $this->assertContains("A", $test);
    }

    public function testToString(): void
    {
        $deck = new Deck;
        $cards = $deck->getCards();

        $this->assertIsString($cards[0]->toString());
    }

    public function testValueOfCards(): void
    {
        $deck = new Deck;
        $cards = $deck->getCards();
        $test = "A";
        $this->assertEquals(11, $cards[0]->getValueOfCard($test));

        $test = "K";
        $this->assertEquals(10, $cards[12]->getValueOfCard($test));

        $test = "6";
        $this->assertEquals(6, $cards[5]->getValueOfCard($test));
    }

    public function testTypeOfCards(): void
    {
        $deck = new Deck;
        $cards = $deck->getCards();

        $this->assertEquals("A", $cards[0]->getTypeOfCard());
    }

}