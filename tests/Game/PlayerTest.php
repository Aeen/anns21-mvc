<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{
    public function testGetCurrentScore(): void
    {
        $player = new Player();
        $deck = new Deck;
        $pulledCard = $deck->drawCard();
        $player->setCurrentScore($pulledCard);

        $this->assertEquals(11, $player->getCurrentScore());
    }

    public function testClearCurrentHand(): void
    {
        $player = new Player();

        $player->clearCurrentHand();

        $this->assertEquals(0, $player->getCurrentScore());
        $this->assertEmpty($player->getCurrentHand());
    }

    public function testSetCurrentHand(): void
    {
        $player = new Player();
        $deck = new Deck;
        $pulledCard = $deck->drawCard();
        $player->setCurrentHand($pulledCard);

        $cards = $player->getCurrentHand();
        $test = $cards[0]->getDetails();

        $this->assertContains("♥", $test);
        $this->assertContains("A", $test);
    }

    public function testCreatePlayer(): void
    {
        $player = new Player();
        $dealer = new Player('dealer');

        $this->assertEquals('player', $player->getPlayer());
        $this->assertEquals('dealer', $dealer->getPlayer());

        $this->expectExceptionMessage('Invalid player type.');
        $playerWrong = new Player('playaa');
    }

}