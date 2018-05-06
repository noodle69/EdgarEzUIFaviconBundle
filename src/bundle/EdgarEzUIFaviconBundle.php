<?php

namespace Edgar\EzUIFaviconBundle;

use Edgar\EzUIFaviconBundle\DependencyInjection\Compiler\FaviconsPass;
use Edgar\EzUIFaviconBundle\DependencyInjection\Security\PolicyProvider\UIFaviconPolicyProvider;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\EzPublishCoreExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EdgarEzUIFaviconBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /** @var EzPublishCoreExtension $eZExtension */
        $eZExtension = $container->getExtension('ezpublish');
        $eZExtension->addPolicyProvider(new UIFaviconPolicyProvider($this->getPath()));

        $container->addCompilerPass(new FaviconsPass());
    }
}
