<?php

namespace Bookshelf\Controller\ReadLog;

use Bookshelf\Repository\ReadLogRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller {

    public function handleAction(Request $request, ReadLogRepository $repo): Response {
        $term = $request->get('term');
        $logs = $repo->findLogsMatching($this->getUser(), $term);

        return $this->render('home.html.twig', ['logs' => $logs]);
    }
}
