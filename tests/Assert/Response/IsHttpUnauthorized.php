<?php

declare(strict_types=1);

namespace App\Tests\Assert\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Проверка на 401 код в ответе от сервера
 */
final class IsHttpUnauthorized extends AbstractIsHttpCode
{
    public function __construct()
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED);
    }
}
