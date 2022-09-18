<?php

declare(strict_types=1);

namespace App\Core\Entity;

/**
 * Доменная сущность.
 */
interface AggregationRootInterface
{
    /**
     * Получение отложенных событий.
     *
     * @return DomainEventInterface[]
     */
    public function releaseEvents(): array;
}
