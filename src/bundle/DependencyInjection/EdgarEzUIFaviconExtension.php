<?php

namespace Edgar\EzUIFaviconBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class EdgarEzUIFaviconExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yml');
        $loader->load('default_settings.yml');

        $processor = new ConfigurationProcessor($container, 'edgar_ez_ui_favicon');
        $processor->mapSetting('api_key', $config);
        $processor->mapSetting('favicon_design', $config);
        $processor->mapSetting('baseurl', $config);
        $processor->mapSetting('uri', $config);
        $processor->mapSetting('versioning', $config);
    }

    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('assetic', array('bundles' => array('EdgarEzUIFaviconBundle')));
    }
}
