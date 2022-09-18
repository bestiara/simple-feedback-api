<?php

declare(strict_types=1);

namespace App\Infrastructure\Flusher;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Флашер изменений UoW.
 */
final class Flusher
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function flush(): void
    {
        $uow = $this->entityManager->getUnitOfWork();
        $uow->computeChangeSets();

        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
