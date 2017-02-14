<?php
namespace IvixLabs\BusBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class HandlerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('ivixlabs.bus');
        $services = $container->findTaggedServiceIds('ivixlabs.bus.handler');

        foreach ($services as $serviceId => $attributes) {
            $handlerDefinition = $container->getDefinition($serviceId);
            $handlerDefinition->setLazy(true);

            $ref = new \ReflectionClass($handlerDefinition->getClass());
            $method = $ref->getMethod('__invoke');
            $params = $method->getParameters();

            if (count($params) !== 1) {
                throw new \RuntimeException('__invoke must has 1 object argument');
            }

            $param = $params[0];

            $class = $param->getClass();

            if ($class === null) {
                throw new \RuntimeException('__invoke must has 1 object argument');
            }


            $definition->addMethodCall('addHandler', [$class->getName(),  new Reference($serviceId)]);
        }
    }


}