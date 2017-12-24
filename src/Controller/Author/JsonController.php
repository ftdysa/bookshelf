<?php

declare(strict_types=1);

namespace Bookshelf\Controller\Author;

use Bookshelf\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\SerializerInterface;

class JsonController extends Controller {
    public function handleAction(AuthorRepository $repo, SerializerInterface $serializer): Response {
        $authors = $repo->findAuthors();

        $json = $serializer->serialize($authors, 'json', [
            'attributes' => ['id', 'name'],
        ]);

        return new JsonResponse($json, 200, [], true);
    }
}
