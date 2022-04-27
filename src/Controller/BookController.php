<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProductRepository;
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
        $book->setPicture("img/" . $picture);

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
     * @Route("/book/search", name="book-search")
     */
    public function search(Request $request): Response
    {
        $data = [
            'title' => $request->query->get('title'),
        ];

        return $this->render('book/home.html.twig', $data);
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

    // return $this->json($products);

    $data = [
        'title' => 'Books',
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
        $book = $bookRepository
            ->find($id);

            $data = [
                'title' => 'Books',
                'books' => $book
            ];
        
            return $this->render('book\books.html.twig', $data);
    }

    // /**
    //  * @Route("/product/delete/{id}", name="product_delete_by_id")
    //  */
    // public function deleteBookById(
    //     ManagerRegistry $doctrine,
    //     int $id
    // ): Response {
    //     $entityManager = $doctrine->getManager();
    //     $product = $entityManager->getRepository(Product::class)->find($id);

    //     if (!$product) {
    //         throw $this->createNotFoundException(
    //             'No product found for id '.$id
    //         );
    //     }

    //     $entityManager->remove($product);
    //     $entityManager->flush();

    //     return $this->redirectToRoute('product_show_all');
    // }

    // /**
    //  * @Route("/product/update/{id}/{value}", name="product_update")
    //  */
    // public function updateBook(
    //     ManagerRegistry $doctrine,
    //     int $id,
    //     int $value
    // ): Response {
    //     $entityManager = $doctrine->getManager();
    //     $product = $entityManager->getRepository(Product::class)->find($id);

    //     if (!$product) {
    //         throw $this->createNotFoundException(
    //             'No product found for id '.$id
    //         );
    //     }

    //     $product->setValue($value);
    //     $entityManager->flush();

    //     return $this->redirectToRoute('product_show_all');
    // }
}
