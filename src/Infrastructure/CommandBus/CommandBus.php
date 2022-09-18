<?php

declare(strict_types=1);

namespace App\Infrastructure\CommandBus;

use App\Infrastructure\Flusher\Flusher;
use League\Tactician\Bundle\Middleware\InvalidCommandException;
use League\Tactician\CommandBus as Bus;

/**
 * Шина команд.
 */
final class CommandBus implements CommandBusInterface
{
    public function __construct(
        private Bus $commandBus,
        private Flusher $flusher,
    ) {
    }

    public function handle(object $command): void
    {
        try {
            $this->commandBus->handle($command);
        } catch (InvalidCommandException $exception) {
            throw new CommandValidationException($exception->getViolations(), $exception);
        }

        $this->flusher->flush();
    }
}
