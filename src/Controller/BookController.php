<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookController extends AbstractController
{
    /**
    * @Route("/book", name="book")
    */
    public function home(
        EntityManagerInterface $entityManager
    ): Response {
    $books = $entityManager
        ->getRepository(Book::class)
        ->findAll();

    // return $this->json($products);

    $data = [
        'title' => 'Books',
        'books' => $books
    ];

    return $this->render('book\home.html.twig', $data);
    }

    /**
     * @Route(
     *      "/book/create",
     *      name="create_book",
     *      methods={"GET","HEAD"}
     * )
     */
    public function createBook(): Response 
        {
            return $this->render('book\create.html.twig');
        }

    /**
     * @Route(
     *      "/book/create",
     *      name="create-process",
     *      methods={"POST"}
     * )
     */
    public function createProcess(
        ManagerRegistry $doctrine,
        Request $request
        ): Response
    {
        $entityManager = $doctrine->getManager();

        $title = $request->request->get('title');
        $isbn  = $request->request->get('isbn');
        $author = $request->request->get('author');
        $picture = $request->request->get('picture');

        $book = new Book();
        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setPicture($picture);

        $pictureName = $book->getPicture();
        $book->setPictureMap($pictureName);

        $pictureName = $book->getPicture();
        $book->setPictureEnd($pictureName);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $type = "notice";
        $this->addFlash($type, "Boken är tillagd");

        return $this->redirectToRoute('create_book');
    }

    /**
     * @Route("/book/show", name="book_show_all")
     */
    public function showAllBooks(
        EntityManagerInterface $entityManager
    ): Response {
    $books = $entityManager
        ->getRepository(Book::class)
        ->findAll();

    //var_dump($books);
    $data = [
        'title' => 'Show all books',
        'books' => $books
    ];

    return $this->render('book\books.html.twig', $data);
    }

    /**
     * @Route("/book/show/{id}", name="book_by_id")
     */
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $books[] = $bookRepository
            ->find($id);

        //var_dump($books);
        $data = [
            'title' => 'Book by ID',
            'books' => $books
        ];
        
        return $this->render('book\onebook.html.twig', $data);
    }

    /**
     * @Route(
     *      "/book/delete/{id}",
     *      name="delete_book",
     *      methods={"GET","HEAD"}
     * )
     */
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager
            ->getRepository(Book::class)
            ->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        //return $this->redirectToRoute('book_show_all');
        return $this->redirectToRoute('book');
    }


    /**
     * @Route(
     *      "/book/update/{id}",
     *      name="update_book",
     *      methods={"GET","HEAD"}
     * )
     */
    public function updateBook(
        BookRepository $bookRepository,
        int $id
    ): Response 
        {
        $books[] = $bookRepository
            ->find($id);

        //var_dump($books);
        $data = [
            'title' => 'Book by ID',
            'books' => $books
        ];

            return $this->render('book\update.html.twig', $data);
        }

    /**
     * @Route(
     *      "/book/update/{id}",
     *      name="update-process",
     *      methods={"POST"}
     * )
     */
    public function updateProcess(
        ManagerRegistry $doctrine,
        Request $request
        ): Response
    {
        $entityManager = $doctrine->getManager();

        $id = $request->request->get('id');
        $title = $request->request->get('title');
        $isbn  = $request->request->get('isbn');
        $author = $request->request->get('author');
        $picture = $request->request->get('picture');

        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setPicture($picture);

        $pictureName = $book->getPicture();
        $book->setPictureMap($pictureName);

        $pictureName = $book->getPicture();
        $book->setPictureEnd($pictureName);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $type = "notice";
        $this->addFlash($type, "Boken är uppdaterad");

        return $this->redirectToRoute('update_book', array('id' => $id));
    }
}
