<?php

declare(strict_types=1);

namespace App\Model\Feedback\Service\Fetcher\Component;

/**
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class FeedbackSearchResult
{
    public function __construct(
        public readonly int $total,
        public readonly array $list,
    ) {
    }
}
