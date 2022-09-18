<?php

declare(strict_types=1);

namespace App\Model\Feedback\Service\Fetcher;

use App\Model\Feedback\Entity\Feedback;
use App\Model\Feedback\Service\Fetcher\Component\FeedbackSearchResult;
use Doctrine\ORM\EntityRepository;

/**
 * Получатель списка отзывов
 *
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class FeedbacksFetcher
{
    /**
     * @param EntityRepository<Feedback> $entityRepository
     */
    public function __construct(
        private readonly EntityRepository $entityRepository,
    ) {
    }

    public function fetch(int $page, int $perPage): FeedbackSearchResult
    {
        $total = $this->entityRepository->count([]);

        $list = $this->entityRepository->findBy(
            [],
            [
                'createdAt' => 'ASC',
            ],
            $perPage,
            ($page - 1) * $perPage
        );

        return new FeedbackSearchResult($total, $list);
    }
}
