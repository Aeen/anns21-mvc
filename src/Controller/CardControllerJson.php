<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CardControllerJson
{

    /**
     * @Route(
     *      "/card/api/deck",
     *      name="card-api-deck"
     * )
     */
    public function JsonCard(): Response
    {
        $cardArray = [];
        $cards = new \App\Card\Deck();
        $deck = $cards->get_cards();

        for ($i = 0; $i < count($deck); $i++) {
            array_push($cardArray, $deck[$i]->to_string());
        }

        $data = [
            'title' => 'Json Card',
            'deck' => $cardArray
        ];

        return new JsonResponse($data);
    }

}
