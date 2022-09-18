<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Transformer;

/**
 * Трансформер данных в сырой ассоциативный массив.
 */
interface TransformerInterface
{
    public function getType(): string;
}
