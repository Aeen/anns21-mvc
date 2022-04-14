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
    public function BlackJack(
        Request $request,
        SessionInterface $session
    ): response
    {
        // $dealerHand = $session->get("dealerHand");
        // $playerHand = $session->get("playerHand");

        $start  = $request->request->get('start');
        $reset  = $request->request->get('reset');
        $hit  = $request->request->get('hit');
        $stand  = $request->request->get('stand');

        $player = new \App\Game\Player();
        $dealer = new \App\Game\Player('dealer');

        $playerArray = [];
        $dealerArray = [];
        $deck = new \App\Game\Deck();

        $game = new \App\Game\Game($deck, $player, $dealer);
        $game->start();

        $dealerHand = $dealer->getCurrentHand();
        $playerHand = $player->getCurrentHand();

        for ($i = 0; $i < count($dealerHand); $i++) {
            array_push($dealerArray, $dealerHand[$i]->toString());
        }

        for ($i = 0; $i < count($playerHand); $i++) {
            array_push($playerArray, $playerHand[$i]->toString());
        }

            print_r($dealerArray);
            print_r($playerArray);

        $dealerScore = $dealer->getCurrentScore();
        $playerScore = $player->getCurrentScore();

        $data = [
            'title' => 'Card',
            'dealerHand' => $dealerArray,
            'playerHand' => $playerArray,
            'dealerScore' => $dealerScore,
            'playerScore' => $playerScore
        ];

        // $session->set("dealerHand", $dealerHand);
        // $session->set("playerHand", $playerHand);

        return $this->render('game\play.html.twig', $data);
    }
}
