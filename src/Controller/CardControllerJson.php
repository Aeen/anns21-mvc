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
    public function jsonCard(): Response
    {
        $cardArray = [];
        $cards = new \App\Card\Deck();
        $deck = $cards->getCards();

        for ($i = 0; $i < count($deck); $i++) {
            array_push($cardArray, $deck[$i]->toString());
        }

        $data = [
            'title' => 'Json Card',
            'deck' => $cardArray
        ];

        // return new JsonResponse($data);

        $response = new JsonResponse([$data]);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return $response;
    }
}
