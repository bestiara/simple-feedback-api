<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Request;

/**
 * Пагинация.
 */
final class Pageable
{
    private int $perPage;
    private int $page;
    private string $url;

    public function __construct(int $perPage, int $page, string $url)
    {
        $this->perPage = $perPage;
        $this->page = $page;
        $this->url = $url;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
