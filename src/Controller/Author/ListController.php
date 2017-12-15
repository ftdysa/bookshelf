<?php

declare(strict_types=1);

namespace Bookshelf\Controller\Author;

use Bookshelf\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListController extends Controller {
    public function handleAction(Request $request, AuthorRepository $repo, int $page): Response {
        $authors = $repo->findAuthors($page);

        return $this->render('author/home.html.twig', ['authors' => $authors]);
    }
}
