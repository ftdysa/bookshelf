<?php

declare(strict_types=1);

namespace Bookshelf\Controller\ReadLog;

use Bookshelf\Entity\Author;
use Bookshelf\Entity\ReadLog;
use Bookshelf\Form\CreateReadLogModel;
use Bookshelf\Form\CreateReadLogType;
use Bookshelf\Repository\ReadLogRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditController extends Controller {
    public function handleAction(Request $request, ReadLogRepository $repo, int $id): Response {
        $log = $repo->findLog($id);
        if (!$log) {
            throw $this->createNotFoundException('Log not found');
        }

        $form = $this->createForm(CreateReadLogType::class, CreateReadLogModel::createFromEntity($log));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $this->isValidRequest($request, $form)) {
            $this->updateLog($log, $request, $form);
            $this->addFlash('success', 'Log entry saved.');

            return $this->redirectToRoute('read_log_edit', ['id' => $id]);
        }

        return $this->render('readlog/create.html.twig', [
            'form' => $form->createView(),
            'authorIds' => implode(
                ',',
                array_map(
                    function (Author $author) {
                        return $author->getId();
                    },
                    $log->getBook()->getAuthors()->getValues()
                )
            ),
        ]);
    }

    // TODO: clean up this and createLog.
    private function updateLog(ReadLog $log, Request $request, FormInterface $form) {
        $em = $this->getDoctrine()->getManager();
        $book = $log->getBook();
        $book->clearAuthors();

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

        /* @var $model CreateReadLogModel */
        $model = $form->getData();
        $book->setName($model->getBook());
        $log->setBook($book);
        $log->setNote($model->getComment());
        $log->setDateRead($model->getDateRead());
        // Force an update so that the log will get indexed on book/author changes.
        // Probably a better way to do this.
        $log->setDateUpdated(new \DateTime());

        $em->persist($log);
        $em->flush();
    }
}
