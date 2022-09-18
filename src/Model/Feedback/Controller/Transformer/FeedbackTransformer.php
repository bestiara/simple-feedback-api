<?php

declare(strict_types=1);

namespace App\Model\Feedback\Controller\Transformer;

use App\Infrastructure\Controller\Transformer\TransformerInterface;
use App\Model\Feedback\Entity\Feedback;
use League\Fractal\TransformerAbstract;

/**
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class FeedbackTransformer extends TransformerAbstract implements TransformerInterface
{
    public const TYPE = 'feedback';

    public function transform(Feedback $feedback): array
    {
        return [
            'id' => $feedback->getId()->toString(),
            'name' => $feedback->getName(),
            'phone' => $feedback->getPhone(),
            'createdAt' => $feedback->getCreatedAt()->format(DATE_ATOM),
        ];
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
