<?php

declare(strict_types=1);

namespace App\Model\Feedback\Entity;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Репозиторий отзывов
 *
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class FeedbackRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Добавление отзыва
     */
    public function add(Feedback $article): void
    {
        $this->entityManager->persist($article);
    }
}
