<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * 200 OK.
 */
final class OkResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct([
            'data' => [],
            'meta' => [],
        ]);
    }
}
