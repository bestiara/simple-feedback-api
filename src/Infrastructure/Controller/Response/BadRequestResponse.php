<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * 400 Bad Request.
 */
final class BadRequestResponse extends JsonResponse
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
            self::HTTP_BAD_REQUEST
        );
    }
}
