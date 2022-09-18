<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Event\Subscriber;

use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

/**
 * Слушатель события postGenerateSchema для вырезания из миграций лишней строки со схемой.
 */
final class FixPostgreSQLDefaultSchemaListener
{
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schema = $args->getSchema();

        if (!$schema->hasNamespace('public')) {
            $schema->createNamespace('public');
        }
    }
}
