<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * 201 Created.
 */
final class CreatedResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct(
            [
                'data' => [],
                'meta' => [],
            ],
            self::HTTP_CREATED
        );
    }
}
