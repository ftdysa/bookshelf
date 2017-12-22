<?php

namespace Bookshelf\Controller\ReadLog;

use Bookshelf\Entity\Author;
use Bookshelf\Entity\Book;
use Bookshelf\Entity\ReadLog;
use Bookshelf\Form\CreateReadLogModel;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as ControllerBase;

abstract class Controller extends ControllerBase {

    protected function isValidRequest(Request $request, FormInterface $form) {
        $postData = $request->request->get($form->getName());
        $authors = isset($postData['authors']) ?? [];

        if (!$authors) {
            $form->get('authors')->addError(new FormError('You need to provide at least one author.'));
            return false;
        }

        return $form->isValid();
    }
}
