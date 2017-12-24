<?php

namespace Bookshelf\Controller\Author;

use Bookshelf\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewController extends Controller {

    public function handleAction(Request $request, AuthorRepository $repo, int $id): Response {
        $author = $repo->findAuthor($id);
        if (!$author) {
            throw $this->createNotFoundException('Author not found');
        }

        return $this->render('author/view.html.twig', [
            'author' => $author,
        ]);
    }
}
