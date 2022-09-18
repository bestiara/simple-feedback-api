<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Event\Subscriber;

use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Парсит запрос, если видит Content-Type = application/json.
 */
final class JsonToArrayConverterSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'convert',
        ];
    }

    public function convert(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        $content = $request->getContent();

        if ($request->getContentType() !== 'json') {
            return;
        }

        try {
            /** @var array $data */
            $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR) ?: [];

            $request->request->replace($data);
        } catch (Exception $exception) {
            throw new BadRequestHttpException('invalid json body: ' . json_last_error_msg());
        }
    }
}
