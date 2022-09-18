<?php

declare(strict_types=1);

namespace App\Model\Feedback\Controller;

use App\Infrastructure\CommandBus\CommandBusInterface;
use App\Infrastructure\CommandBus\CommandValidationException;
use App\Infrastructure\Controller\AbstractController;
use App\Model\Feedback\Controller\Request\FeedbackCreateRequestData;
use App\Model\Feedback\Entity\FeedbackId;
use App\Model\Feedback\UseCase\Create\FeedbackCreateCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Создание отзыва
 *
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
final class FeedbackCreateController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(FeedbackCreateRequestData $requestData): Response
    {
        $request = Request::createFromGlobals();

        $command = new FeedbackCreateCommand(
            FeedbackId::next(),
            $requestData->name,
            $requestData->phone,
            $request->getClientIp() ?? ''
        );

        try {
            $this->commandBus->handle($command);
        } catch (CommandValidationException $exception) {
            return $this->createCommandViolationsResponse($exception->violations);
        }

        return $this->createCreatedResponse();
    }
}
