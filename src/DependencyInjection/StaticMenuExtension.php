<?php

namespace Sokil\StaticMenuBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class StaticMenuExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // prepare config
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // load services
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // create services
        foreach ($config as $menuName => $menuConfiguration) {
            // alias
            $menuAlias = 'static_menu.' . $menuName;

            // create definition
            $definition = new Definition();
            $definition
                ->setClass('Knp\Menu\MenuItem')
                ->setFactory([new Reference('static_menu.builder'), 'build'])
                ->setArguments([$menuConfiguration])
                ->addTag(
                    'knp_menu.menu', [
                        'alias' => $menuAlias,
                    ]
                );

            // set definition to container
            $container->setDefinition($menuAlias, $definition);
        }

    }
}
