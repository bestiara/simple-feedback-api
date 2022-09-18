<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * 400 Bad Request с ошибками валидации бизнес-команды.
 */
final class CommandViolationsRequestResponse extends JsonResponse
{
    public function __construct(ConstraintViolationListInterface $violations)
    {
        parent::__construct(
            [
                'data' => [],
                'errors' => $this->getErrors($violations),
                'meta' => [],
            ],
            self::HTTP_BAD_REQUEST
        );
    }

    private function getErrors(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[] = [
                'code' => $violation->getCode(),
                'source' => $violation->getPropertyPath(),
                'title' => $violation->getMessage(),
            ];
        }

        return $errors;
    }
}
