<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Bundle\DependencyInjection;

use Freema\HeurekaAPI\Api;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Symfony DependencyInjection Extension for Heureka Košík API
 *
 * This extension loads and manages the configuration for the Heureka Košík API
 * bundle and registers the API service in the Symfony container.
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class HeurekaKosikApiExtension extends Extension
{
    /**
     * Loads the bundle configuration and registers services
     *
     * @param array<int, array<string, mixed>> $configs The configuration array
     * @param ContainerBuilder $container The container builder
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Register the Heureka API service
        $definition = new Definition(Api::class);
        $definition->setArguments([
            $config['api_key'],
            $config['debug'],
        ]);
        $definition->setPublic(true);
        $definition->setAutowired(true);
        $definition->setAutoconfigured(true);

        $container->setDefinition(Api::class, $definition);
        $container->setAlias('heureka_kosik_api', Api::class)->setPublic(true);
    }

    /**
     * Returns the recommended alias to use in XML
     *
     * @return string The alias
     */
    public function getAlias(): string
    {
        return 'heureka_kosik_api';
    }
}
