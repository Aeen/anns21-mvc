<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function home(): Response
    {
        return $this->render('card\card.html.twig');
    }


    /**
     * @Route("/card/deck", name="card-deck")
     */
    public function card(): response
    {
        $cardArray = [];
        $cards = new \App\Card\Deck();
        $deck = $cards->get_cards();

        for ($i = 0; $i < count($deck); $i++) {
            array_push($cardArray, $deck[$i]->to_string());
        }

        $data = [
            'title' => 'Deck',
            'deck' => $cardArray
            /* 'deck' => [
                '1' => "A2",
                '2' => "A3",
                '3' => "A4",
            ], */
        ];
        return $this->render('card\card.html.twig', $data);
    }
}
