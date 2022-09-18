<?php

declare(strict_types=1);

namespace App\Model\Feedback\UseCase\Create;

use App\Model\Feedback\Entity\Feedback;
use App\Model\Feedback\Entity\FeedbackRepository;

/**
 * Обработчик создания отзыва
 *
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
final class FeedbackCreateCommandHandler
{
    public function __construct(
        private readonly FeedbackRepository $feedbackRepository,
    ) {
    }

    public function __invoke(FeedbackCreateCommand $command): void
    {
        $feedback = new Feedback(
            $command->id,
            $command->name,
            $command->phone,
            $command->ip,
        );

        $this->feedbackRepository->add($feedback);
    }
}
