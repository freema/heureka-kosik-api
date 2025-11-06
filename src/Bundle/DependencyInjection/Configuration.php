<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration schema for Heureka Košík API Bundle
 *
 * This class defines the configuration tree for the bundle, including
 * validation rules and default values.
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('heureka_kosik_api');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('api_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('Your Heureka Košík API key (recommended to use environment variable)')
                    ->example('%env(HEUREKA_API_KEY)%')
                ->end()
                ->booleanNode('debug')
                    ->defaultFalse()
                    ->info('Enable debug mode to use test API endpoint')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
