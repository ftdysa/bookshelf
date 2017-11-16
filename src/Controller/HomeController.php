<?php

namespace Bookshelf\Controller;

use Symfony\Component\HttpFoundation\Request;

class HomeController {
    private $twig;

    public function __construct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function handleAction(Request $request) {
        $name = $request->get('name') ?? 'Nobody';
        return $this->twig->render('index.html.twig', ['name' => $name]);
    }
}