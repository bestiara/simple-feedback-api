<?php

declare(strict_types=1);

namespace App\Infrastructure\CommandBus\Container\HandlerMapping;

use League\Tactician\Bundle\DependencyInjection\HandlerMapping\TagBasedMapping;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class CommandHandlerMapping extends TagBasedMapping
{
    protected function isSupported(ContainerBuilder $container, Definition $definition, array $tagAttributes): bool
    {
        return true;
    }

    protected function findCommandsForService(ContainerBuilder $container, Definition $definition, array $tagAttributes): array
    {
        /** @var string $class */
        $class = $definition->getClass();

        return [
            preg_replace('/Handler$/', '', $class),
        ];
    }
}
