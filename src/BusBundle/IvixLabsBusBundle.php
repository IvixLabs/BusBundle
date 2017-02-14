<?php
namespace IvixLabs\BusBundle;

use IvixLabs\BusBundle\DependencyInjection\BusExtension;
use IvixLabs\BusBundle\DependencyInjection\HandlerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IvixLabsBusBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new HandlerCompilerPass());
    }

    public function getContainerExtension()
    {
        return new BusExtension();
    }


}
