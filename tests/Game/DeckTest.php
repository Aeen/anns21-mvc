<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Deck.
 */
class DeckTest extends TestCase
{
    public function testDeckContains52Cards(): void
    {
        $deck = new Deck;
        $this->assertEquals(52, count($deck->getCards()));
    }

    public function testDrawnCards(): void
    {
        $deck = new Deck;
        $drawnCards = $deck->drawCard();
        $this->assertEquals(51, count($deck->getCards()));
    }

    public function testShuffle(): void
    {
        $deck = new Deck;
        $shuffledDeck = $deck->shuffleDeck();
        $this->assertNotEquals($deck, $shuffledDeck);
    }
}