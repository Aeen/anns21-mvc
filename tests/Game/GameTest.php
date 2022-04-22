<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game.
 */
class GameTest extends TestCase
{
    public function testCreateGame(): void
    {
        $deck = new Deck();
        $player = new Player();
        $dealer = new Player('dealer');
        $game = new Game($deck, $player, $dealer);

        $this->assertEquals('play', $game->readStand());
    }

    public function testStart(): void
    {
        $deck = new Deck();
        $player = new Player();
        $dealer = new Player('dealer');
        $game = new Game($deck, $player, $dealer);
        $game->start();

        $this->assertEquals(48, count($deck->getCards()));
    }

    public function testStand(): void
    {
        $deck = new Deck();
        $player = new Player();
        $dealer = new Player('dealer');
        $game = new Game($deck, $player, $dealer);

        $game->stand();

        $this->assertEquals('stand', $game->readStand());
    }

    public function testHit(): void
    {
        $deck = new Deck();
        $player = new Player();
        $dealer = new Player('dealer');
        $game = new Game($deck, $player, $dealer);

        $scoreBefore = $player->getCurrentScore();

        $game->hit();

        $scoreAfter = $player->getCurrentScore();

        $this->assertNotEquals($scoreBefore, $scoreAfter);
    }

    public function testDealerHit(): void
    {
        $deck = new Deck();
        $player = new Player();
        $dealer = new Player('dealer');
        $game = new Game($deck, $player, $dealer);

        $scoreBefore = $dealer->getCurrentScore();

        $game->dealerHit();

        $scoreAfter = $dealer->getCurrentScore();

        $this->assertNotEquals($scoreBefore, $scoreAfter);
    }

    public function testCheckForWinner(): void
    {
        $deck = new Deck();
        $player = new Player();
        $dealer = new Player('dealer');
        $game = new Game($deck, $player, $dealer);


        $res = $game->checkForWinner();
        $exp = '';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(17);
        $dealer->setCurrentScoreNum(17);

        $res = $game->checkForWinner();
        $exp = 'Dealer won';
        $this->assertEquals($exp, $res);


        $player->setCurrentScoreNum(18);
        $dealer->setCurrentScoreNum(18);

        $res = $game->checkForWinner();
        $exp = 'Dealer won';
        $this->assertEquals($exp, $res);


        $player->setCurrentScoreNum(19);
        $dealer->setCurrentScoreNum(19);

        $res = $game->checkForWinner();
        $exp = 'Dealer won';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(20);
        $dealer->setCurrentScoreNum(20);

        $res = $game->checkForWinner();
        $exp = 'Shared first place';
        $this->assertEquals($exp, $res);


        $player->setCurrentScoreNum(21);
        $dealer->setCurrentScoreNum(21);

        $res = $game->checkForWinner();
        $exp = 'Shared first place';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(21);
        $dealer->setCurrentScoreNum(20);

        $res = $game->checkForWinner();
        $exp = 'BlackJack for player';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(20);
        $dealer->setCurrentScoreNum(21);

        $res = $game->checkForWinner();
        $exp = 'BlackJack for dealer';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(12);
        $dealer->setCurrentScoreNum(22);

        $res = $game->checkForWinner();
        $exp = 'Player won';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(22);
        $dealer->setCurrentScoreNum(12);

        $res = $game->checkForWinner();
        $exp = 'Dealer won';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(20);
        $dealer->setCurrentScoreNum(17);

        $res = $game->checkForWinner();
        $exp = 'Player won';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(22);
        $dealer->setCurrentScoreNum(22);

        $res = $game->checkForWinner();
        $exp = 'Both lost';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(17);
        $dealer->setCurrentScoreNum(20);
        $game->stand();

        $res = $game->checkForWinner();
        $exp = 'Dealer won';
        $this->assertEquals($exp, $res);
    }

    public function testCheckForWinnerWhilePlaying(): void
    {
        $deck = new Deck();
        $player = new Player();
        $dealer = new Player('dealer');
        $game = new Game($deck, $player, $dealer);


        $res = $game->checkForWinnerWhilePlaying();
        $exp = '';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(20);
        $dealer->setCurrentScoreNum(20);

        $res = $game->checkForWinnerWhilePlaying();
        $exp = 'Shared first place';
        $this->assertEquals($exp, $res);


        $player->setCurrentScoreNum(21);
        $dealer->setCurrentScoreNum(21);

        $res = $game->checkForWinnerWhilePlaying();
        $exp = 'Shared first place';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(21);
        $dealer->setCurrentScoreNum(20);

        $res = $game->checkForWinnerWhilePlaying();
        $exp = 'BlackJack for player';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(20);
        $dealer->setCurrentScoreNum(21);

        $res = $game->checkForWinnerWhilePlaying();
        $exp = 'BlackJack for dealer';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(12);
        $dealer->setCurrentScoreNum(22);

        $res = $game->checkForWinnerWhilePlaying();
        $exp = 'Player won';
        $this->assertEquals($exp, $res);



        $player->setCurrentScoreNum(22);
        $dealer->setCurrentScoreNum(12);

        $res = $game->checkForWinnerWhilePlaying();
        $exp = 'Dealer won';
        $this->assertEquals($exp, $res);


        $player->setCurrentScoreNum(22);
        $dealer->setCurrentScoreNum(22);

        $res = $game->checkForWinnerWhilePlaying();
        $exp = 'Both lost';
        $this->assertEquals($exp, $res);
    }
}
