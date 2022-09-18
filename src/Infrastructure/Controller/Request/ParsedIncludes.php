<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Request;

/**
 * Include запроса для дополнительных данных в json:api ответе.
 */
final class ParsedIncludes
{
    public function __construct(
        public readonly array $includes
    ) {
    }
}
