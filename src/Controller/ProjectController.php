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
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;

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
    * @Route("/proj/reset", name="reset-database")
    */
    public function resetDatabase(KernelInterface $kernel): Response
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'sqlite3 var/data.db < var/backup.sql'
        ]);

        $output = new NullOutput();
        $application->run($input, $output);


        return new Response("");

        //return $this->redirectToRoute('project_about');

        //return $this->redirectToRoute('project_about')->with(new Response, '');
    }


    /**
     * @Route(
     *      "/proj/start",
     *      name="create_game",
     *      methods={"GET","HEAD"}
     * )
     */
    public function createGame(): Response
    {
        return $this->render('project\create.html.twig');
    }


    /**
     * @Route(
     *      "/proj/start",
     *      name="create-game-process",
     *      methods={"POST"}
     * )
     */
    public function createProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $name = $request->request->get('name');

        //var_dump($name);

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

        $player = $adventure->getId();

        //return $this->redirectToRoute('project_playing');
        return $this->redirectToRoute('project_playing', array('playerId' => $player));
    }


    /**
    * @Route("/proj/play/{playerId}", name="project_playing")
    */
    public function status(
        EntityManagerInterface $entityManager,
        int $playerId
    ): Response {
        $adventure = array();
        $adventure[] = $entityManager
        ->getRepository(Adventure::class)
        ->find($playerId);



        $id = 1;
        $room = array();
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
    * @Route("/proj/play/{playerId}/{id}", name="continue_playing", methods={"GET"})
    */
    public function continueplay(
        ManagerRegistry $doctrine,
        int $playerId,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();

        $type = "dead";

        $room = array();
        $room[] = $entityManager
        ->getRepository(Room::class)
        ->find($id);

        $adventure = $entityManager
        ->getRepository(Adventure::class)
        ->find($playerId);

        if (!$playerId) {
            throw $this->createNotFoundException(
                'No player found for id ' . $playerId
            );
        }

        if ($id === 3) {
            $adventure->fight(25);
        }

        if ($id === 9) {
            $adventure->fight(40);
        }

        if ($id === 10) {
            $adventure->fight(40);
        }

        if ($adventure->getLife() < 1) {
            $this->addFlash($type, "Spelet har börjat om eftersom ditt liv tog slut!");
            return $this->redirectToRoute('restart-game', array('playerId' => $playerId));
        }

        if ($adventure->getFood() < 1) {
            $this->addFlash($type, "Spelet har börjat om eftersom du svalt ihjäl!");
            return $this->redirectToRoute('restart-game', array('playerId' => $playerId));
        }

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($adventure);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $game = array();
        $game[] = $adventure;

        $data = [
        'status' => $game,
        'rooms' => $room
        ];

        return $this->render('project\play.html.twig', $data);
    }

    // /**
    // * @Route("/proj/play/{playerId}/{id}", name="project_play", methods={"POST"})
    // */
    // public function playing(
    //     ManagerRegistry $doctrine,
    //     Request $request,
    //     int $playerId,
    //     int $id
    // ): Response {
    //     $entityManager = $doctrine->getManager();

    //     //$playerId = $request->request->get('playerId');
    //     $action1 = $request->request->get('action1');
    //     $action2 = $request->request->get('action2');
    //     $type = "notice";


    //     $player = $entityManager
    //     ->getRepository(Adventure::class)
    //     ->find($playerId);


    //     //var_dump($player);

    //     if (!$playerId) {
    //         throw $this->createNotFoundException(
    //             'No player found for id ' . $playerId
    //         );
    //     }

    //     $player->getHungry(10);

    //     if ($action1 !== null) {
    //         // Test if string contains the word

    //         if (strpos($action1, "Plocka") !== false) {
    //             if (strpos($action1, "bananerna") !== false) {
    //                 if ($player->getBanana() != 1) {
    //                     $player->setBanana(1);
    //                     $this->addFlash($type, "Bananerna ligger i din ryggsäck!");
    //                 } else {
    //                     $this->addFlash($type, "Bananerna ligger redan i din ryggsäck!");
    //                 }
    //             }
    //             if (strpos($action1, "snigeln") !== false) {
    //                 if ($player->getSnail() != 1) {
    //                     $player->setSnail(1);
    //                     $this->addFlash($type, "Snigeln ligger i din ryggsäck!");
    //                 } else {
    //                     $this->addFlash($type, "Snigeln ligger redan i din ryggsäck!");
    //                 }
    //             }
    //             if (strpos($action1, "drycken") !== false) {
    //                 if ($player->getPotion() != 1) {
    //                     $player->setPotion(1);
    //                     $this->addFlash($type, "Drycken ligger i din ryggsäck!");
    //                 } else {
    //                     $this->addFlash($type, "Drycken ligger redan i din ryggsäck!");
    //                 }
    //             }
    //             if (strpos($action1, "nyckeln") !== false) {
    //                 if ($player->getKeys() != 1) {
    //                     $player->setKeys(1);
    //                     $this->addFlash($type, "Nyckeln ligger i din ryggsäck!");
    //                 } else {
    //                     $this->addFlash($type, "Nyckeln ligger redan i din ryggsäck!");
    //                 }
    //             }
    //         }

    //         if (strpos($action1, "Drick") !== false) {
    //             if ($player->getPotion() != 1) {
    //                 $this->addFlash($type, "Du har ingen dryck att dricka!");
    //             } else {
    //                 $player->setPotion(0);
    //                 $player->setLife(100);
    //                 $player->setFood(100);
    //                 $this->addFlash($type, "Drycken är nu slut!");
    //             }
    //         }

    //         if (strpos($action1, "Ät") !== false) {
    //             if ($player->getBanana() != 1) {
    //                 $this->addFlash($type, "Du har inga bananer att äta!");
    //             } else {
    //                 $player->setBanana(0);
    //                 $player->eat(40);
    //                 $this->addFlash($type, "Bananerna är nu uppätna!");
    //             }
    //         }

    //         if (strpos($action1, "Kasta") !== false) {
    //             if (strpos($action1, "banan") !== false) {
    //                 if ($player->getBanana() != 0) {
    //                     $player->setBanana(0);
    //                     $this->addFlash($type, "Du har kastat bananerna åt apan. Apan ger dig en smäll
    //                     innan han tar bananerna och går iväg.");
    //                 } else {
    //                     $this->addFlash($type, "Du har inga bananer att kasta!");
    //                 }
    //             }

    //             if (strpos($action1, "snigel") !== false) {
    //                 if ($player->getSnail() != 0) {
    //                     $player->setSnail(0);
    //                     $this->addFlash($type, "Bläckfisken kramar om dig med alla sina armar innan den
    //                     upptäcker snigeln du kastat åt honom. Bläckfisken släpper dig för att ånjuta
    //                     en snigelmåltid.");
    //                 } else {
    //                     $this->addFlash($type, "Du har inga sniglar att kasta!");
    //                 }
    //             }
    //         }

    //         if (strpos($action1, "Slåss") !== false) {
    //             if (strpos($action1, "apan") !== false) {
    //                 $this->addFlash($type, "Apan hoppar på dig för att ge igen! Du håller på att bli skadad.");
    //             }
    //             if (strpos($action1, "bläckfisken") !== false) {
    //                 $this->addFlash($type, "Bläckfisken ger sig på dig för att skydda sitt bo!
    //                 Du håller på att bli allvarligt skadad.");
    //             }
    //         }

    //         if (strpos($action1, "Lås upp kistan") !== false) {

    //             if ($player->getKeys() != 1) {
    //                 $this->addFlash($type, "Du har ingen nyckel att öpnna kistan med!");
    //             } else {
    //             // tell Doctrine you want to (eventually) save the Product
    //             // (no queries yet)
    //             $entityManager->persist($player);

    //             // actually executes the queries (i.e. the INSERT query)
    //             $entityManager->flush();
    //             $id = 12;

    //             return $this->redirectToRoute('continue_playing', array('playerId' => $playerId, 'id' => $id));
    //             }

    //         }
    //     }



    //     if ($action2 !== null) {
    //         // Test if string contains the word

    //         if (strpos($action2, "Plocka") !== false) {
    //             if (strpos($action2, "bananerna") !== false) {
    //                 if ($player->getBanana() != 1) {
    //                     $player->setBanana(1);
    //                     $this->addFlash($type, "Bananerna ligger i din ryggsäck!");
    //                 } else {
    //                     $this->addFlash($type, "Bananerna ligger redan i din ryggsäck!");
    //                 }
    //             }

    //             if (strpos($action2, "snigeln") !== false) {
    //                 if ($player->getSnail() != 1) {
    //                     $player->setSnail(1);
    //                     $this->addFlash($type, "Snigeln ligger i din ryggsäck!");
    //                 } else {
    //                     $this->addFlash($type, "Snigeln ligger redan i din ryggsäck!");
    //                 }
    //             }
    //             if (strpos($action2, "drycken") !== false) {
    //                 if ($player->getPotion() != 1) {
    //                     $player->setPotion(1);
    //                     $this->addFlash($type, "Drycken ligger i din ryggsäck!");
    //                 } else {
    //                     $this->addFlash($type, "Drycken ligger redan i din ryggsäck!");
    //                 }
    //             }
    //             if (strpos($action2, "nyckeln") !== false) {
    //                 if ($player->getKeys() != 1) {
    //                     $player->setKeys(1);
    //                     $this->addFlash($type, "Nyckeln ligger i din ryggsäck!");
    //                 } else {
    //                     $this->addFlash($type, "Nyckeln ligger redan i din ryggsäck!");
    //                 }
    //             }
    //         }

    //         if (strpos($action2, "Drick") !== false) {
    //             if ($player->getPotion() != 1) {
    //                 $this->addFlash($type, "Du har ingen dryck att dricka!");
    //             } else {
    //                 $player->setPotion(0);
    //                 $player->setLife(100);
    //                 $player->setFood(100);
    //                 $this->addFlash($type, "Drycken är nu slut!");
    //             }
    //         }

    //         if (strpos($action2, "Ät") !== false) {
    //             if ($player->getBanana() != 1) {
    //                 $this->addFlash($type, "Du har inga bananer att äta!");
    //             } else {
    //                 $player->setBanana(0);
    //                 $player->eat(30);
    //                 $this->addFlash($type, "Bananerna är nu uppätna!");
    //             }
    //         }

    //         if (strpos($action2, "Kasta") !== false) {
    //             if (strpos($action2, "banan") !== false) {
    //                 if ($player->getBanana() != 0) {
    //                     $player->setBanana(0);
    //                     $this->addFlash($type, "Du har kastat bananerna åt apan.
    //                     Apan ger dig en smäll innan han tar bananerna och går iväg.");
    //                 } else {
    //                     $this->addFlash($type, "Du har inga fler bananer att kasta!");
    //                 }
    //             }

    //             if (strpos($action2, "snigel") !== false) {
    //                 if ($player->getSnail() != 0) {
    //                     $player->setSnail(0);
    //                     $this->addFlash($type, "Bläckfisken kramar om dig med alla sina armar innan den
    //                     upptäcker snigeln du kastat åt honom. Bläckfisken släpper dig för att ånjuta
    //                     en snigelmåltid.");
    //                 } else {
    //                     $this->addFlash($type, "Du har inga fler sniglar att kasta!");
    //                 }
    //             }
    //         }

    //         if (strpos($action2, "Slåss") !== false) {
    //             if (strpos($action2, "apan") !== false) {
    //                 $this->addFlash($type, "Apan hoppar på dig för att ge igen! Du håller på att bli skadad.");
    //             }
    //             if (strpos($action2, "bläckfisken") !== false) {
    //                 $this->addFlash($type, "Bläckfisken ger sig på dig för att skydda sitt bo!
    //                 Du håller på att bli allvarligt skadad.");
    //             }
    //         }
    //     }



    //     // tell Doctrine you want to (eventually) save the Product
    //     // (no queries yet)
    //     $entityManager->persist($player);

    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();

    //     return $this->redirectToRoute('continue_playing', array('playerId' => $playerId, 'id' => $id));
    // }


    /**
    * @Route("/proj/play/{playerId}/{id}", name="project_play", methods={"POST"})
    */
    public function playing(
        ManagerRegistry $doctrine,
        Request $request,
        int $playerId,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();

        //$playerId = $request->request->get('playerId');
        $action1 = $request->request->get('action1');
        $action2 = $request->request->get('action2');
        $type = "notice";


        $player = $entityManager
        ->getRepository(Adventure::class)
        ->find($playerId);


        //var_dump($player);

        if (!$playerId) {
            throw $this->createNotFoundException(
                'No player found for id ' . $playerId
            );
        }

        $player->getHungry(10);


        if (strpos($action1, "Plocka upp bananerna") !== false) {
            $player->setBanana(1);
            $this->addFlash($type, "Bananerna ligger i din ryggsäck!");
        }

        if (strpos($action1, "Plocka upp snigeln") !== false) {
            $player->setSnail(1);
            $this->addFlash($type, "Snigeln ligger i din ryggsäck!");
        }

        if (strpos($action1, "Plocka upp drycken") !== false) {
            $player->setPotion(1);
            $this->addFlash($type, "Drycken ligger i din ryggsäck!");
        }

        if (strpos($action1, "Plocka upp nyckeln") !== false) {
            $player->setKeys(1);
            $this->addFlash($type, "Nyckeln ligger i din ryggsäck!");
        }

        if (strpos($action1, "Drick drycken") !== false) {
            $player->setPotion(0);
            $player->setLife(100);
            $player->setFood(100);
            $this->addFlash($type, "Drycken är uppdrucken!");
        }

        if (strpos($action1, "Ät en banan") !== false) {
            $player->setBanana(0);
            $player->eat(40);
            $this->addFlash($type, "Bananerna är uppätna!");
        }

        if (strpos($action1, "Kasta en banan") !== false) {
            $player->setBanana(0);
            $this->addFlash($type, "Du har kastat bananerna åt apan. Apan ger dig en smäll  
                        innan han tar bananerna och går iväg.");
        }

        if (strpos($action1, "Kasta en snigel") !== false) {
            $player->setSnail(0);
            $this->addFlash($type, "Bläckfisken kramar om dig med alla sina armar innan den 
                        upptäcker snigeln du kastat åt honom. Bläckfisken släpper dig för att ånjuta   
                        en snigelmåltid.");
        }

        if (strpos($action1, "Slåss mot apan") !== false) {
            $this->addFlash($type, "Apan hoppar på dig för att ge igen! Du håller på att bli skadad.");
        }

        if (strpos($action1, "Slåss mot bläckfisken") !== false) {
            $this->addFlash($type, "Bläckfisken ger sig på dig för att skydda sitt bo!  
                    Du håller på att bli allvarligt skadad.");
        }


        if (strpos($action1, "Lås upp kistan") !== false) {
            if ($player->getKeys() != 1) {
                $this->addFlash($type, "Du har ingen nyckel att öpnna kistan med!");
            } else {
                // tell Doctrine you want to (eventually) save the Product
                // (no queries yet)
                $entityManager->persist($player);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
                $id = 12;

                return $this->redirectToRoute('continue_playing', array('playerId' => $playerId, 'id' => $id));
            }
        }


        if (strpos($action2, "Plocka upp bananerna") !== false) {
            $player->setBanana(1);
            $this->addFlash($type, "Bananerna ligger i din ryggsäck!");
        }

        if (strpos($action2, "Plocka upp snigeln") !== false) {
            $player->setSnail(1);
            $this->addFlash($type, "Snigeln ligger i din ryggsäck!");
        }

        if (strpos($action2, "Plocka upp drycken") !== false) {
            $player->setPotion(1);
            $this->addFlash($type, "Drycken ligger i din ryggsäck!");
        }

        if (strpos($action2, "Plocka upp nyckeln") !== false) {
            $player->setKeys(1);
            $this->addFlash($type, "Nyckeln ligger i din ryggsäck!");
        }

        if (strpos($action2, "Drick drycken") !== false) {
            $player->setPotion(0);
            $player->setLife(100);
            $player->setFood(100);
            $this->addFlash($type, "Drycken är uppdrucken!");
        }

        if (strpos($action2, "Ät en banan") !== false) {
            $player->setBanana(0);
            $player->eat(40);
            $this->addFlash($type, "Bananerna är uppätna!");
        }

        if (strpos($action2, "Kasta en banan") !== false) {
            $player->setBanana(0);
            $this->addFlash($type, "Du har kastat bananerna åt apan. Apan ger dig en smäll  
                innan han tar bananerna och går iväg.");
        }

        if (strpos($action2, "Kasta en snigel") !== false) {
            $player->setSnail(0);
            $this->addFlash($type, "Bläckfisken kramar om dig med alla sina armar innan den 
                upptäcker snigeln du kastat åt honom. Bläckfisken släpper dig för att ånjuta   
                en snigelmåltid.");
        }

        if (strpos($action2, "Slåss mot apan") !== false) {
            $this->addFlash($type, "Apan hoppar på dig för att ge igen! Du håller på att bli skadad.");
        }

        if (strpos($action2, "Slåss mot bläckfisken") !== false) {
            $this->addFlash($type, "Bläckfisken ger sig på dig för att skydda sitt bo!  
            Du håller på att bli allvarligt skadad.");
        }




        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($player);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('continue_playing', array('playerId' => $playerId, 'id' => $id));
    }

    /**
     * @Route(
     *      "/proj/restart/{playerId}",
     *      name="restart-game"
     * )
     */
    public function restartGame(
        ManagerRegistry $doctrine,
        int $playerId
    ): Response {
        $entityManager = $doctrine->getManager();

        $player = $entityManager
        ->getRepository(Adventure::class)
        ->find($playerId);


        $player->setLife(100);
        $player->setFood(100);
        $player->setSnail(0);
        $player->setBanana(0);
        $player->setKeys(0);
        $player->setPotion(0);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($player);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        //return $this->redirectToRoute('project_playing');
        return $this->redirectToRoute('project_playing', array('playerId' => $playerId));
    }
}
