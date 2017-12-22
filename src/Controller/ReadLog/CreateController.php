<?php

declare(strict_types=1);

namespace Bookshelf\Controller\ReadLog;

use Bookshelf\Entity\Author;
use Bookshelf\Entity\Book;
use Bookshelf\Entity\ReadLog;
use Bookshelf\Form\CreateReadLogModel;
use Bookshelf\Form\CreateReadLogType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends Controller {
    public function handleAction(Request $request): Response {
        $model = new CreateReadLogModel();
        $form = $this->createForm(CreateReadLogType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $this->isValidRequest($request, $form)) {
            $log = $this->createLog($request, $form);
            $this->addFlash('success', 'Log entry saved.');

            return $this->redirectToRoute('read_log_edit', ['id' => $log->getId()]);
        }

        return $this->render('readlog/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    protected function createLog(Request $request, FormInterface $form): ReadLog {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        /* @var $model CreateReadLogModel */
        $model = $form->getData();
        $user = $this->getUser();
        $bookName = $model->getBook();
        $book = new Book();
        $book->setName($bookName);

        // Authors gets some custom handling.
        // Array values that are numeric indicate a selected author.
        $authors = $request->request->get($form->getName())['authors'];

        foreach ($authors['name'] as $idOrName) {
            if (is_numeric($idOrName)) {
                $book->addAuthor($em->getReference(Author::class, $idOrName));
            } else {
                $author = new Author();
                $author->setName($idOrName);

                $book->addAuthor($author);
            }
        }

        $book->setAddedBy($user);

        $log = new ReadLog();
        $log->setBook($book);
        $log->setNote($model->getComment());
        $log->setDateRead($model->getDateRead());
        $log->setUser($user);

        $em->persist($log);
        $em->flush();

        return $log;
    }
}
