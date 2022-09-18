<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * 204 No Content.
 */
final class NoContentResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct(
            [
                'data' => [],
                'meta' => [],
            ],
            self::HTTP_NO_CONTENT
        );
    }
}
