<?php

declare(strict_types=1);

namespace Bookshelf\Controller\ReadLog;

class SearchController extends Controller {
    public function handleAction() {
        return $this->render('readlog/search.html.twig');
    }
}
