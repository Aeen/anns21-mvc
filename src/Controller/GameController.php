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
        return $this->render('game\play.html.twig');
    }
}