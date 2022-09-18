<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * 404 Not Found.
 */
final class NotFoundResponse extends JsonResponse
{
    public function __construct(string $code, string $message)
    {
        parent::__construct(
            [
                'data' => [],
                'errors' => [
                    [
                        'code' => $code,
                        'title' => $message,
                    ],
                ],
                'meta' => [],
            ],
            self::HTTP_NOT_FOUND
        );
    }
}
