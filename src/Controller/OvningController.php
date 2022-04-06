<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OvningController extends AbstractController
{
    /**
     * @Route("/ovning", name="ovning")
     */
    public function ovning(): Response
    {
        return $this->render('pages\ovning.html.twig');
    }
}
