<?php

namespace Edgar\EzUIFaviconBundle\DependencyInjection\Compiler;

use Edgar\EzUIFavicon\Generator\Generator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FaviconsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $faviconsViewPath = $container->getParameter('kernel.root_dir') . '/../web/' . $container->getParameter('ezsettings.admin_group.var_dir') . '/' . $container->getParameter('ezsettings.default.storage_dir') . '/images/' . Generator::FAVICONS_DIR;
        if (!is_dir($faviconsViewPath)) {
            mkdir($faviconsViewPath, '077', true);
        }

        $container->getDefinition('twig.loader.filesystem')->addMethodCall('addPath', [$faviconsViewPath]);
    }
}
