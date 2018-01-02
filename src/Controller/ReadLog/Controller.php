<?php

declare(strict_types=1);

namespace Bookshelf\Controller\ReadLog;

use Symfony\Component\Form\FormError;
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
