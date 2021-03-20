<?php

namespace App\DependencyInjection;

use App\Logger;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LoggerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $ids = $container->findTaggedServiceIds('with_logger');
        foreach ($ids as $key => $value) {
            $definition = $container->getDefinition($key);
            $definition->addMethodCall('setLogger', [new Reference(Logger::class)]);
        }
    }
}
