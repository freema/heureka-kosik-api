<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Bridges;

use Freema\HeurekaAPI\Api;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

/**
 * Nette Framework DI Extension for Heureka Košík API
 *
 * This extension provides seamless integration of Heureka Košík API client
 * into Nette Framework applications through the Dependency Injection container.
 *
 * Configuration example:
 * ```yaml
 * extensions:
 *     heurekaKosikApi: Freema\HeurekaAPI\Bridges\HeurekaKosikApiExtension
 *
 * heurekaKosikApi:
 *     key: YOUR_API_KEY  # or use %env.HEUREKA_API_KEY%
 *     debug: false       # Set to true for test API endpoint
 *     autowired: true    # Enable autowiring (default)
 * ```
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class HeurekaKosikApiExtension extends CompilerExtension
{
    /**
     * Defines the configuration schema for this extension
     *
     * @return Schema Configuration schema
     */
    public function getConfigSchema(): Schema
    {
        return Expect::structure([
            'key' => Expect::string()->nullable()->dynamic(),
            'debug' => Expect::bool(false),
            'autowired' => Expect::bool(true),
        ]);
    }

    /**
     * Loads configuration and registers services
     *
     * @throws \InvalidArgumentException If API key is not provided in production mode
     */
    public function loadConfiguration(): void
    {
        $container = $this->getContainerBuilder();
        /** @var \stdClass{key: ?string, debug: bool, autowired: bool} $config */
        $config = $this->getConfig();

        // Validate API key
        $apiKey = $config->key;
        if ($apiKey === null) {
            throw new \InvalidArgumentException(
                'Heureka API key is required. Please set it in your config.neon ' .
                'or use environment variable via %env.HEUREKA_API_KEY%',
            );
        }

        // Register the API service
        $container->addDefinition($this->prefix('api'))
            ->setFactory(Api::class, [$apiKey, $config->debug])
            ->setAutowired($config->autowired);
    }
}
