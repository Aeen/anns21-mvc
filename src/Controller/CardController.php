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


       /**
    * @Route(
    *       "/card/deck/deal/:players/:cards",
    *       name="card-draw-deal",
    *       methods={"POST", "GET"}
    * )
    */
    public function deal(
        Request $request
    ): response
    {
        $numCards  = $request->request->get('cards') ?? 0;
        $numPlayers  = $request->request->get('players') ?? 0;
        $num = $numCards * $numPlayers;

        $cardArray = [];
        $stringArray = [];
        $cards = new \App\Card\Deck();
        $cards->shuffle_deck();
        $deck = $cards->get_cards();
        $playerArray = [];
        //$playerArray = new \App\Card\Player();
        $deckSize = count($deck);

        if ($numCards == 0 && $numPlayers == 0) {

            $this->addFlash("info", "Välj antal spelare och kort för att börja spela!");

        } elseif ($deckSize < $num)  {

            $this->addFlash("info", "Det finns inte tillräckligt med kort i kortleken.");

        } elseif ($deckSize >= $num)  {

            for ($k = 0; $k < $numPlayers; $k++) {

                unset($cardArray);
                $cardArray = array();
                for ($i = 0; $i < $numCards; $i++) {
                    array_push($cardArray, $cards->draw_card());
                }
    
                //print_r($cardArray);

                unset($stringArray);
                $stringArray = array();
                for ($i = 0; $i < count($cardArray); $i++) {
                    array_push($stringArray, $cardArray[$i]->to_string());
                }

                array_push($playerArray, $stringArray);
            }

        } 

        $deck = $cards->get_cards();
        $numLeft = count($deck);

        //print_r($playerArray);

        $data = [
            'title' => 'Deal',
            'qty' => $numLeft,
            'deck' => $playerArray,
            'link_to_play' => $this->generateUrl('card-draw-deal', ['cards' => $numCards, 'player' => $numPlayers]),
        ];

        return $this->render('card\player.html.twig', $data);
    }

   
}
