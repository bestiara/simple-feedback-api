<?php

declare(strict_types=1);

namespace App\Tests\Assert\Response;

use PHPUnit\Framework\Constraint\Constraint;

abstract class AbstractIsHttpCode extends Constraint
{
    protected int $expectedCode;

    public function __construct(int $expectedCode)
    {
        $this->expectedCode = $expectedCode;
    }

    public function evaluate($response, string $description = '', bool $returnResult = false): ?bool
    {
        return parent::evaluate($response->getStatusCode());
    }

    public function matches($code): bool
    {
        return $code === $this->expectedCode;
    }

    public function toString(): string
    {
        return sprintf(
            'is equal to %s',
            $this->expectedCode
        );
    }

    protected function failureDescription($code): string
    {
        return 'HTTP code of response ' . $code . ' ' . $this->toString();
    }
}
