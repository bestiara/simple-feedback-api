<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Event\Subscriber;

use App\Infrastructure\Http\Exception\RequestValidationFailedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

/**
 * Глобальный обработчик исключений.
 */
final class KernelExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = $this->getResponse($exception);

        $event->setResponse($response);
    }

    private function getResponse(Throwable $exception): JsonResponse
    {
        if ($exception instanceof RequestValidationFailedException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            $errors = [];

            foreach ($exception->violations as $violation) {
                $errors[] = [
                    'code' => $violation->getCode(),
                    'source' => $violation->getPropertyPath(),
                    'title' => $violation->getMessage(),
                ];
            }
        } else {
            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            } else {
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            }

            $errors = [
                [
                    'code' => (string)$exception->getCode(),
                    'title' => $exception->getMessage(),
                ],
            ];
        }

        $data = [
            'data' => [],
            'errors' => $errors,
            'meta' => [],
        ];

        return new JsonResponse(
            json_encode($data, JSON_THROW_ON_ERROR, 512),
            $statusCode,
            [],
            true
        );
    }
}
