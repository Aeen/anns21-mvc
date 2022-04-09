<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


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
            'title' => 'Card',
            'deck' => $cardArray
            /* 'deck' => [
                '1' => "A2",
                '2' => "A3",
                '3' => "A4",
            ], */
        ];
        
        return $this->render('card\card.html.twig', $data);
    }


    /**
    * @Route("/card/deck/shuffle", name="card-shuffle")
    */
    public function shuffle(
        SessionInterface $session
    ): response
    {

        $cardArray = [];
        $cards = new \App\Card\Deck();
        $deck = $cards->get_cards();

        shuffle($deck);

        for ($i = 0; $i < count($deck); $i++) {
            array_push($cardArray, $deck[$i]->to_string());
        }

        $data = [
            'title' => 'Shuffle',
            'deck' => $cardArray
        ];

        $session->set("deck", $deck);

        return $this->render('card\card.html.twig', $data);
    }


    // /**
    // * @Route(
    // *       "/card/deck/draw",
    // *       name="card-draw",
    // *       methods={"GET"}
    // * )
    // */
    // public function draw(): response
    // {
    //     $num = 1;
    //     $cardArray = [];
    //     $printArray = [];
    //     $cards = new \App\Card\Deck();
    //     $deck = $cards->get_cards();

    //     shuffle($deck);

    //     // for ($i = 0; $i < 5; $i++) {
    //     //     array_push($cardArray, array_shift($deck));
    //     // }


    //     $cardArray = $cards->deal_cards($num, $deck);

    //     for ($i = 0; $i < count($cardArray); $i++) {
    //         array_push($printArray, $cardArray[$i]->to_string());
    //     }

    //     $numLeft = count($deck);

    //     $data = [
    //         'title' => 'Draw',
    //         'qty' => $numLeft,
    //         'deck' => $printArray,
    //         'link_to_draw' => $this->generateUrl('card-draw', ['number' => 5,]),
    //     ];
    //     return $this->render('card\draw.html.twig', $data);
    // }

/**
    * @Route(
    *       "/card/deck/draw",
    *       name="card-draw",
    *       methods={"GET", "POST"}
    * )
    */
    public function draw(
        Request $request,
        SessionInterface $session
    ): response
    {
        $deck = $session->get("deck") ?? new \App\Card\Deck();
        $num  = $request->request->get('number') ?? 1;
        $cardArray = [];
        $printArray = [];

        $numCards = count($deck);

        if ($numCards >= $num) {     

            shuffle($deck);

            for ($i = 0; $i < $num; $i++) {
                array_push($cardArray, array_shift($deck));
            }
    
            for ($i = 0; $i < count($cardArray); $i++) {
                array_push($printArray, $cardArray[$i]->to_string());
            }

        } elseif ($numCards == 0) {
            $cards = new \App\Card\Deck();
            $deck = $cards->get_cards();

            $this->addFlash("info", "Kortleken har blandats på nytt.");
            $this->addFlash("info", "Nu kan du dra fler kort igen.");

        } elseif ($numCards < $num)  {

            $this->addFlash("info", "Du kan bara dra " . $numCards . " kort.");
        }
        

        $numLeft = count($deck);

        $data = [
            'title' => 'Draw',
            'qty' => $numLeft,
            'deck' => $printArray,
            'link_to_draw' => $this->generateUrl('card-draw-num', ['number' => $num]),
        ];

        $session->set("deck", $deck);

        return $this->render('card\draw.html.twig', $data);
    }

    /**
    * @Route(
    *       "/card/deck/draw/:number",
    *       name="card-draw-num",
    *       methods={"POST", "GET"}
    * )
    */
    public function draw_number(
        Request $request,
        SessionInterface $session
    ): response
    {
        $deck = $session->get("deck") ?? new \App\Card\Deck();

        $num  = $request->request->get('number') ?? 1;

        $cardArray = [];
        $printArray = [];
        $cards = new \App\Card\Deck();
        $deck = $cards->get_cards();

        $numCards = count($deck);

        if ($numCards >= $num) {     

            shuffle($deck);

            for ($i = 0; $i < $num; $i++) {
                array_push($cardArray, array_shift($deck));
            }
    
            for ($i = 0; $i < count($cardArray); $i++) {
                array_push($printArray, $cardArray[$i]->to_string());
            }

        } elseif ($numCards == 0) {
            $cards = new \App\Card\Deck();
            $deck = $cards->get_cards();

            $this->addFlash("info", "Kortleken har blandats på nytt.");
            $this->addFlash("info", "Nu kan du dra fler kort igen.");

        } elseif ($numCards < $num)  {

            $this->addFlash("info", "Du kan bara dra " . $numCards . " kort.");
        }

        $numLeft = count($deck);

        $data = [
            'title' => 'Draw number',
            'qty' => $numLeft,
            'deck' => $printArray,
            'link_to_draw' => $this->generateUrl('card-draw-num', ['number' => $num]),
        ];

        $session->set("deck", $deck);

        return $this->render('card\draw.html.twig', $data);
    }
   
}
