<?php

namespace Bookshelf\Controller\Book;

use Bookshelf\Repository\AuthorRepository;
use Bookshelf\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListController extends Controller {

    public function handleAction(Request $request, BookRepository $repo, int $page): Response {
        $books = $repo->findBooks($page);

        return $this->render('book/home.html.twig', ['books' => $books]);
    }
}