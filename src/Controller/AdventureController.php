<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adventure;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AdventureRepository;
use Doctrine\ORM\EntityManagerInterface;

class AdventureController extends AbstractController
{
    /**
     * @Route("/adventure/show", name="adventure_show_all")
     */
    public function showAllAdventures(
        EntityManagerInterface $entityManager
    ): Response {
        $adventure = $entityManager
        ->getRepository(Adventure::class)
        ->findAll();

        //var_dump($adventure);
        $data = [
        'games' => $adventure
        ];

        return $this->render('room\adventures.html.twig', $data);
    }

    /**
     * @Route(
     *      "/adventure/delete/{id}",
     *      name="delete_adventure",
     *      methods={"GET","HEAD"}
     * )
     */
    public function deleteAdventureById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $adventure = $entityManager
            ->getRepository(Adventure::class)
            ->find($id);

        if (!$id) {
            throw $this->createNotFoundException(
                'No adventure found for id ' . $id
            );
        }

        $entityManager->remove($adventure);
        $entityManager->flush();

        return $this->redirectToRoute('adventure_show_all');
    }
}
