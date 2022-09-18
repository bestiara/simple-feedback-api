<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Request;

use League\Fractal\Pagination\PaginatorInterface;
use League\Uri\Uri;
use League\Uri\UriModifier;

/**
 * Пагинатор для списков.
 */
final class Paginator implements PaginatorInterface
{
    private Pageable $pageable;
    private int $total;
    private int $totalPages;

    public function __construct(Pageable $pageable, int $total)
    {
        $this->pageable = $pageable;
        $this->total = $total;
        $this->totalPages = (int)ceil($this->total / $this->getPerPage());
    }

    public function getCount(): int
    {
        if ($this->totalPages !== $this->getCurrentPage()) {
            return $this->getPerPage();
        }

        return $this->total % $this->getPerPage();
    }

    public function getLastPage(): int
    {
        $lastPage = (int)ceil($this->total / $this->getPerPage());

        return $lastPage > 0 ? $lastPage : 1;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getPerPage(): int
    {
        return $this->pageable->getPerPage();
    }

    public function getCurrentPage(): int
    {
        return $this->pageable->getPage();
    }

    public function getUrl(int $page): string
    {
        $uri = UriModifier::mergeQuery(
            Uri::createFromString($this->pageable->getUrl()),
            sprintf('pre-page=%d&page=%d', $this->getPerPage(), $page)
        );

        return (string)$uri;
    }
}
