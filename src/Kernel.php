<?php

namespace App;

//use App\Infrastructure\CommandBus\Container\HandlerMapping\CommandHandlerMapping;
//use League\Tactician\Bundle\TacticianBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{yaml,yml}';

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir() . '/config/bundles.php';

        /** @var class-string<BundleInterface> $class */
        foreach ($contents as $class => $envs) {
            if (!($envs[$this->environment] ?? $envs['all'] ?? false)) {
                continue;
            }

//            if ($class === TacticianBundle::class) {
//                yield new TacticianBundle(
//                    new CommandHandlerMapping(),
//                );
//            } else {
//                yield new $class();
//            }

            yield new $class();
        }
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import(sprintf('../config/{packages}/*%s', self::CONFIG_EXTS));
        $container->import(sprintf('../config/{packages}/%s/*%s', $this->environment, self::CONFIG_EXTS));

        $container->import(sprintf('./Infrastructure/*/{Resources}/config/*%s', self::CONFIG_EXTS), 'glob');
        $container->import(sprintf('./Infrastructure/*/{Resources}/config/%s/*%s', $this->environment, self::CONFIG_EXTS), 'glob');

        $container->import(sprintf('./Model/*/{Resources}/config/*%s', self::CONFIG_EXTS), 'glob');
        $container->import(sprintf('./Model/*/{Resources}/config/%s/*%s', $this->environment, self::CONFIG_EXTS), 'glob');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $confDir = $this->getProjectDir() . '/src/{Infrastructure,Model}/**/Resources/{routes}';

        $routes->import($confDir . '/*' . self::CONFIG_EXTS, 'glob');
        $routes->import($confDir . '/' . $this->environment . '/*' . self::CONFIG_EXTS, 'glob');
    }
}
