<?php

declare(strict_types=1);

namespace Bookshelf\Controller\ReadLog;

use Bookshelf\Entity\Book;
use Bookshelf\Entity\ReadLog;
use Bookshelf\Form\CreateReadLogModel;
use Bookshelf\Form\CreateReadLogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends Controller {
    public function handleAction(Request $request): Response {
        // TODO: Turn book & author into typeahead's so that you either select from an existing record
        // or create a new one.

        $model = new CreateReadLogModel();
        $form = $this->createForm(CreateReadLogType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->saveLog($form->getData());

            return $this->redirectToRoute('index');
        }

        return $this->render('readlog/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function saveLog(CreateReadLogModel $model) {
        $user = $this->getUser();
        $book = $model->getBook();
        $book->addAuthor($model->getAuthor());
        $book->setAddedBy($user);

        $log = new ReadLog();
        $log->setBook($book);
        $log->setNote($model->getComment());
        $log->setDateRead($model->getDateRead());
        $log->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($log);
        $em->flush();
    }
}
