<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Adventure;
use App\Entity\Room;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AdventureRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectController extends AbstractController
{
    /**
     * @Route("/proj", name="project")
     */
    public function project(): Response
    {
        return $this->render('project\index.html.twig');
    }

        /**
     * @Route("/proj/about", name="project_about")
     */
    public function about(): Response
    {
        return $this->render('project\about.html.twig');
    }

    /**
     * @Route(
     *      "/proj/start",
     *      name="create_game"
     * )
     */
    public function createGame(): Response
    {
        return $this->render('project\create.html.twig');
    }


    /**
     * @Route(
     *      "/proj/start",
     *      name="create-process",
     *      methods={"POST"}
     * )
     */
    public function createProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $name = $request->request->get('name');

        $adventure = new Adventure();
        $adventure->setName($name);
        $adventure->setLife(100);
        $adventure->setFood(100);
        $adventure->setSnail(0);
        $adventure->setBanana(0);
        $adventure->setKeys(0);
        $adventure->setPotion(0);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($adventure);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $type = "notice";
        $this->addFlash($type, "Nytt spel startat!");

        return $this->redirectToRoute('project_playing');
    }


    /**
    * @Route("/proj/play", name="project_playing")
    */
    public function status(
        EntityManagerInterface $entityManager,
        RoomRepository $roomRepository
    ): Response {

        $adventure = $entityManager
        ->getRepository(Adventure::class)
        ->findAll();

        $id = 1;
        $room[] = $entityManager
        ->getRepository(Room::class)
        ->find($id );

        $data = [
        'status' => $adventure,
        'rooms' => $room
        ];

        return $this->render('project\play.html.twig', $data);
    }

        /**
    * @Route("/proj/play/{id}", name="continue_playing")
    */
    public function continueplay(
        EntityManagerInterface $entityManager,
        RoomRepository $roomRepository,
        int $id
    ): Response {

        $adventure = $entityManager
        ->getRepository(Adventure::class)
        ->findAll();

        $room[] = $entityManager
        ->getRepository(Room::class)
        ->find($id);


        $data = [
        'status' => $adventure,
        'rooms' => $room
        ];

        return $this->render('project\play.html.twig', $data);
    }

        /**
    * @Route("/proj/play", name="project_play", methods={"POST"})
    */
    public function playing(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {


        $playerId = $request->request->get('id') ?? null;
        $action1 = $request->request->get('action1') ?? null;
        $action2 = $request->request->get('action2') ?? null;

        $player = $entityManager->getRepository(Adventure::class)->find($playerId);

        if (!$playerId) {
            throw $this->createNotFoundException(
                'No player found for id ' . $playerId
            );
        }

        if ($action1 !== null) {
            // Test if string contains the word 
            if(strpos($mystring, $word) !== false){
                echo "Word Found!";
            } else{
                echo "Word Not Found!";
            }
            
        }

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($player);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('continue_playing', array('id' => $id));
    }
}
