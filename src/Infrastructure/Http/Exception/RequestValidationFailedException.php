<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class RequestValidationFailedException extends RuntimeException
{
    public function __construct(
        public readonly ConstraintViolationListInterface $violations
    ) {
        parent::__construct();
    }
}
