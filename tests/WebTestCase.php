<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;
use Symfony\Component\HttpKernel\HttpKernelBrowser;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Базовый класс для тестов с поднятием приложения
 */
abstract class WebTestCase extends KernelTestCase
{
    use WebTestAssertionsTrait;

    private array $fixtures = [];

    protected function setUp(): void
    {
        self::bootKernel();

        $fixtures = $this->getFixtures();

        if (!empty($fixtures)) {
            $this->loadFixtures($fixtures);
        }

        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        self::getClient(null);
        $this->fixtures = [];
    }

    protected static function bootKernel(array $options = []): KernelInterface
    {
        if (!self::$booted) {
            parent::bootKernel($options);
        }

        return self::$kernel;
    }

    protected static function createClient(array $options = [], array $server = []): HttpKernelBrowser
    {
        $kernel = static::bootKernel($options);

        $client = $kernel->getContainer()->get('test.client');
        $client->setServerParameters($server);

        return self::getClient($client);
    }

    protected function getFixtures(): array
    {
        return [];
    }

    private function loadFixtures(array $fixtures, string $connectionManager = 'default'): void
    {
        $container = static::getContainer();

        $manager = $container->get(ManagerRegistry::class);
        $em = $manager->getManager($connectionManager);
        $loader = new Loader();

        foreach ($fixtures as $name => $class) {
            /** @var FixtureInterface $fixture */
            $fixture = new $class();

            $loader->addFixture($fixture);
            $this->fixtures[$name] = $fixture;
        }

        $executor = new ORMExecutor($em, new ORMPurger($em));
        $executor->execute($loader->getFixtures(), true);
    }
}
