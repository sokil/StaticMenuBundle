<?php

namespace Sokil\StaticMenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('static_menu');

        $rootNode
            ->useAttributeAsKey('menuNme')
            ->prototype('array')
            ->children()
                ->arrayNode('childrenAttributes')
                    ->children()
                        ->scalarNode('class')->end()
                    ->end()
                ->end()
                ->arrayNode('items')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('label')->isRequired()->end()
                            ->scalarNode('role')->end()
                            ->scalarNode('uri')->end()
                            ->scalarNode('route')->end()
                            ->arrayNode('attributes')
                                ->children()
                                    ->scalarNode('class')->end()
                                ->end()
                            ->end()
                            ->arrayNode('linkAttributes')
                                ->children()
                                    ->scalarNode('class')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
