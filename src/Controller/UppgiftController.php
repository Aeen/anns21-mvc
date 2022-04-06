<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UppgiftController extends AbstractController
{
    /**
     * @Route("/uppgift", name="uppgift")
     */
    public function uppgift(): Response
    {
        return $this->render('pages\uppgift.html.twig');
    }
}
