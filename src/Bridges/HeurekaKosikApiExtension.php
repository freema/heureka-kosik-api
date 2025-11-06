<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Bridges;

use Freema\HeurekaAPI\Api;
use Nette\DI\CompilerExtension;

class HeurekaKosikApiExtension extends CompilerExtension
{
    /**
     * @var array<string, mixed>
     */
    private array $defaults = [
        'key' => null,
        'debug' => true,
        'autowired' => true,
    ];

    public function loadConfiguration(): void
    {
        $container = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        if ($config['key'] === null) {
            $config['key'] = Api::class . '::VALID_API_KEY';
        }

        $container->addDefinition($this->prefix('HeurekaKosikApi'))
            ->setFactory(Api::class, [$config['key'], $config['debug']])
            ->setAutowired($config['autowired']);
    }
}
