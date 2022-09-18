<?php

declare(strict_types=1);

namespace App\Core\Entity;

/**
 * Доменное событие.
 */
interface DomainEventInterface
{
    /**
     * Имя события.
     */
    public function getEventName(): string;
}
