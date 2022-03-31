<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReportController extends AbstractController
{
    /**
     * @Route("/report")
     */
    public function index(): Response
    {
        /* return new Response(
            '<html><body>Index</body></html>'
        ); */

        return $this->render('pages\report.html.twig');
    }
}
