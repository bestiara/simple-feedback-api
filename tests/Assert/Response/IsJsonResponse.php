<?php

declare(strict_types=1);

namespace App\Tests\Assert\Response;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\JsonMatchesErrorMessageProvider;

/**
 * Проверка на JSON в ответе
 */
final class IsJsonResponse extends Constraint
{
    public function evaluate($response, string $description = '', bool $returnResult = false): ?bool
    {
        return parent::evaluate($response->getContent());
    }

    public function toString(): string
    {
        return 'is valid JSON';
    }

    protected function matches($other): bool
    {
        if ($other === '') {
            return false;
        }

        json_decode($other, true, 512, JSON_THROW_ON_ERROR);

        return json_last_error() === 0;
    }

    protected function failureDescription($other): string
    {
        if ($other === '') {
            return 'an empty string is valid JSON';
        }

        json_decode($other);
        $error = JsonMatchesErrorMessageProvider::determineJsonError(
            (string)json_last_error()
        );

        return \sprintf(
            '%s is valid JSON (%s)',
            $this->exporter()->shortenedExport($other),
            $error
        );
    }
}
