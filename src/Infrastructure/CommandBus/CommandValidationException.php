<?php

declare(strict_types=1);

namespace App\Infrastructure\CommandBus;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

final class CommandValidationException extends Exception
{
    public function __construct(
        public readonly ConstraintViolationListInterface $violations,
        Throwable $previous
    ) {
        parent::__construct(
            $previous->getMessage(),
            (int)$previous->getCode(),
            $previous
        );
    }
}
