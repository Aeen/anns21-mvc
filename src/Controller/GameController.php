<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
    * @Route("/game", name="game")
    */
    public function home(): Response
    {
        return $this->render('game\home.html.twig');
    }

    /**
    * @Route("/game/doc", name="game-doc")
    */
    public function gameDoc(): Response
    {
        return $this->render('game\gamedoc.html.twig');
    }

    /**
    * @Route("/game/play", name="game-play")
    */
    public function gamePlay(): Response
    {
        return $this->render('game\game.html.twig');
    }

    /**
     * @Route("/game/playing", name="game-playing")
     */
    public function blackJack(
        Request $request,
        SessionInterface $session
    ): response {
        $dealerScore = $session->get("dealerScore") ?? 0;
        $playerScore = $session->get("playerScore") ?? 0;

        $dealerArray = $session->get("dealerArray") ?? [];
        $playerArray = $session->get("playerArray") ?? [];

        $reset  = $request->request->get('reset');
        $hit  = $request->request->get('hit');
        $stand  = $request->request->get('stand');

        $player = $session->get("player") ?? new \App\Game\Player();
        $dealer = $session->get("dealer") ?? new \App\Game\Player('dealer');
        $deck = $session->get("deck") ?? new \App\Game\Deck();
        $game = $session->get("game") ?? new \App\Game\Game($deck, $player, $dealer);

        if ($reset) {
            $player = new \App\Game\Player();
            $dealer = new \App\Game\Player('dealer');
            $deck = new \App\Game\Deck();
            $game = new \App\Game\Game($deck, $player, $dealer);

            $session->set("player", $player);
            $session->set("dealer", $dealer);
            $session->set("deck", $deck);
            $session->set("game", $game);
            $session->set("dealerScore", 0);
            $session->set("playerScore", 0);
            $session->set("dealerArray", []);
            $session->set("playerArray", []);


            $game->start();

            $dealerHand = $dealer->getCurrentHand();
            $playerHand = $player->getCurrentHand();

            for ($i = 0; $i < count($dealerHand); $i++) {
                array_push($dealerArray, $dealerHand[$i]->toString());
            }

            for ($i = 0; $i < count($playerHand); $i++) {
                array_push($playerArray, $playerHand[$i]->toString());
            }

            $dealerScore = $dealer->getCurrentScore();
            $playerScore = $player->getCurrentScore();

            $text = $game->checkForWinnerWhilePlaying();

            $this->addFlash("info", $text);

        } elseif ($hit) {            
            
            $dealerScore = $session->get("dealerScore");
            $playerScore = $session->get("playerScore");

            if ($playerScore > 21) {
                $this->addFlash("info", 'Spelet är slut. Börja om!');
            }
            
            if ($dealerScore < 17) {
                $game->dealerHit();
            }

            if ($playerScore < 21) {
                $game->hit();
            }

            $dealerHand = $dealer->getCurrentHand();
            $playerHand = $player->getCurrentHand();

            for ($i = 0; $i < count($dealerHand); $i++) {
                array_push($dealerArray, $dealerHand[$i]->toString());
            }

            for ($i = 0; $i < count($playerHand); $i++) {
                array_push($playerArray, $playerHand[$i]->toString());
            }

            $dealerScore = $dealer->getCurrentScore();
            $playerScore = $player->getCurrentScore();

            $session->set("dealerScore", $dealerScore);
            $session->set("playerScore", $playerScore);

            $text = $game->checkForWinnerWhilePlaying();

            $this->addFlash("info", $text);
        } elseif ($stand) {
            $dealerScore = $dealer->getCurrentScore();

            while ($dealerScore < 17) {
                $game->dealerHit();
                $dealerScore = $dealer->getCurrentScore();
            }

            $dealerHand = $dealer->getCurrentHand();
            $playerHand = $player->getCurrentHand();

            for ($i = 0; $i < count($dealerHand); $i++) {
                array_push($dealerArray, $dealerHand[$i]->toString());
            }

            for ($i = 0; $i < count($playerHand); $i++) {
                array_push($playerArray, $playerHand[$i]->toString());
            }

            $dealerScore = $dealer->getCurrentScore();
            $playerScore = $player->getCurrentScore();

            $session->set("dealerScore", $dealerScore);
            $session->set("playerScore", $playerScore);

            $text = $game->checkForWinner();

            $this->addFlash("info", $text);
        }


        $data = [
            'title' => 'Card',
            'dealerHand' => $dealerArray,
            'playerHand' => $playerArray,
            'dealerScore' => $dealerScore,
            'playerScore' => $playerScore
        ];

        return $this->render('game\play.html.twig', $data);
    }
}
