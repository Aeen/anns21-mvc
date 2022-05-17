<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Room;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;

class RoomController extends AbstractController
{


    /**
     * @Route(
     *      "/room/create",
     *      name="create_room",
     *      methods={"GET","HEAD"}
     * )
     */
    public function createRoom(): Response
    {
        return $this->render('room\create.html.twig');
    }

    /**
     * @Route(
     *      "/room/create",
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
        $desc  = $request->request->get('description');
        $img = $request->request->get('image');
        $blur = $request->request->get('blur');
        $back = $request->request->get('back');
        $forward1 = $request->request->get('forward1');
        $forward2 = $request->request->get('forward2');
        $action1 = $request->request->get('action1');
        $action2 = $request->request->get('action2');

        $room = new Room();
        $room->setName($name);
        $room->setDescription($desc);
        $room->setImage($img);
        $room->setBlur($blur);
        $room->setBack($back);
        $room->setForward1($forward1);
        $room->setForward2($forward2);
        $room->setAction1($action1);
        $room->setAction2($action2);


        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($room);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $type = "notice";
        $this->addFlash($type, "Rummet är tillagd");

        return $this->redirectToRoute('create_room');
    }

    /**
     * @Route("/room", name="room_show_all")
     */
    public function showAllRooms(
        EntityManagerInterface $entityManager
    ): Response {
        $rooms = $entityManager
        ->getRepository(Room::class)
        ->findAll();

        //var_dump($room);
        $data = [
        'title' => 'Show all books',
        'rooms' => $rooms
        ];

        return $this->render('room\rooms.html.twig', $data);
    }

    /**
     * @Route("/room/show/{id}", name="room_by_id")
     */
    public function showRoomById(
        RoomRepository $roomRepository,
        int $id
    ): Response {
        
        $rooms[] = $roomRepository
            ->find($id);

        //var_dump($books);
        $data = [
            'title' => 'Room by ID',
            'rooms' => $rooms
        ];

        return $this->render('room\oneroom.html.twig', $data);
    }

    /**
     * @Route(
     *      "/room/delete/{id}",
     *      name="delete_room",
     *      methods={"GET","HEAD"}
     * )
     */
    public function deleteRoomById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $room = $entityManager
            ->getRepository(Room::class)
            ->find($id);

        if (!$id) {
            throw $this->createNotFoundException(
                'No room found for id ' . $id
            );
        }

        $entityManager->remove($room);
        $entityManager->flush();

        return $this->redirectToRoute('room_show_all');
    }


    /**
     * @Route(
     *      "/room/update/{id}",
     *      name="update_room",
     *      methods={"GET","HEAD"}
     * )
     */
    public function updateRoom(
        RoomRepository $roomRepository,
        int $id
    ): Response {
        $rooms = array();
        $rooms[] = $roomRepository
            ->find($id);

        //var_dump($books);
        $data = [
            'title' => 'Book by ID',
            'rooms' => $rooms
        ];

        return $this->render('room\update.html.twig', $data);
    }

    /**
     * @Route(
     *      "/room/update/{id}",
     *      name="update-process",
     *      methods={"POST"}
     * )
     */
    public function updateProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $id = $request->request->get('id');
        $name = $request->request->get('name');
        $desc  = $request->request->get('description');
        $img = $request->request->get('image');
        $blur = $request->request->get('blur');
        $back = $request->request->get('back');
        $forward1 = $request->request->get('forward1');
        $forward2 = $request->request->get('forward2');
        $action1 = $request->request->get('action1');
        $action2 = $request->request->get('action2');


        $room = $entityManager->getRepository(Room::class)->find($id);

        if (!$id) {
            throw $this->createNotFoundException(
                'No room found for id ' . $id
            );
        }

        $room->setName($name);
        $room->setDescription($desc);
        $room->setImage($img);
        $room->setBlur($blur);
        $room->setBack($back);
        $room->setForward1($forward1);
        $room->setForward2($forward2);
        $room->setAction1($action1);
        $room->setAction2($action2);


        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($room);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $type = "notice";
        $this->addFlash($type, "Rummet är uppdaterad");

        return $this->redirectToRoute('update_room', array('id' => $id));
    }
}
