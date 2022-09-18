<?php

declare(strict_types=1);

namespace App\Model\Feedback\UseCase\Create;

use App\Model\Feedback\Entity\FeedbackId;
use Webmozart\Assert\Assert;

/**
 * Создание статьи
 *
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class FeedbackCreateCommand
{
    public function __construct(
        public readonly FeedbackId $id,
        public readonly string $name,
        public readonly string $phone,
        public readonly string $ip,
    ) {
        Assert::lengthBetween($this->name, 1, 255);
        Assert::numeric($this->phone);
    }
}
