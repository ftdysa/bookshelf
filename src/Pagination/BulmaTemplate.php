<?php

declare(strict_types=1);

namespace Bookshelf\Pagination;

use Pagerfanta\View\Template\Template;

class BulmaTemplate extends Template {
    public function container() {
        return '<nav class="pagination" role="navigation" aria-label="pagination">%prev% %next%<ul class="pagination-list">%pages%</ul></nav>';
    }

    public function page($page) {
        $text = $page;

        return $this->pageWithText($page, $text);
    }

    public function pageWithText($page, $text) {
        $class = null;

        return $this->pageWithTextAndClass($page, $text, $class);
    }

    private function pageWithTextAndClass($page, $text, $class) {
        $href = $this->generateRoute($page);

        return $this->linkLi($class, $href, $text);
    }

    public function previousDisabled() {
        return '<a class="pagination-previous" title="This is the first page" disabled>Previous</a>';
    }

    public function previousEnabled($page) {
        $href = $this->generateRoute($page);

        return sprintf('<a class="pagination-previous" href="%s">Previous</a>', $href);
    }

    public function nextDisabled() {
        return '<a class="pagination-next" title="This is the last page" disabled>Next</a>';
    }

    public function nextEnabled($page) {
        $href = $this->generateRoute($page);

        return sprintf('<a class="pagination-next" href="%s">Next</a>', $href);
    }

    public function first() {
        return $this->page(1);
    }

    public function last($page) {
        return $this->page($page);
    }

    public function current($page) {
        return $this->linkLi('is-current', $this->generateRoute($page), $page);
    }

    public function separator() {
        return '<li><span class="pagination-ellipsis">&hellip;</span></li>';
    }

    protected function linkLi($class, $href, $text) {
        return sprintf('<li><a href="%s" class="pagination-link %s">%s</a></li>', $href, $class, $text);
    }
}
