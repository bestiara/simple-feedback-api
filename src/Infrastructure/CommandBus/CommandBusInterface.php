<?php

declare(strict_types=1);

namespace App\Infrastructure\CommandBus;

/**
 * Шина команд.
 */
interface CommandBusInterface
{
    /**
     * @throws CommandValidationException
     */
    public function handle(object $command): void;
}
