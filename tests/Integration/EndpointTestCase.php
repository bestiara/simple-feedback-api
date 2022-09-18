<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Tests\Assert\WebAssert;
use App\Tests\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernelBrowser;

/**
 * Абстрактный класс для тестов контроллеров
 */
abstract class EndpointTestCase extends WebTestCase
{
    use WebAssert;

    protected function getApiClient(): HttpKernelBrowser
    {
        return static::createClient([]);
    }
}
