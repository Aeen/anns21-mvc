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
    public function card(): Response
    {
        return $this->render('pages\card.html.twig');
    }
}
