<?php

declare(strict_types=1);

namespace Bookshelf\Controller;

use Bookshelf\Repository\ReadLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller {
    public function handleAction(ReadLogRepository $repo): Response {
        $logs = $repo->findLogsForUser();

        return $this->render('home.html.twig', ['logs' => $logs]);
    }
}
