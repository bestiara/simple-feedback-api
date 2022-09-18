<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * 200 OK с коллекцией сущностей.
 */
final class EntityCollectionResponse extends JsonResponse
{
    public function __construct(array $data, int $statusCode = self::HTTP_OK)
    {
        parent::__construct($data, $statusCode);
    }
}
