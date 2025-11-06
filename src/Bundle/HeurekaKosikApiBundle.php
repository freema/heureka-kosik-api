<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Symfony Bundle for Heureka Košík API
 *
 * This bundle provides seamless integration of Heureka Košík API client
 * into Symfony applications through the Dependency Injection container.
 *
 * Installation:
 * 1. Add to config/bundles.php:
 *    Freema\HeurekaAPI\Bundle\HeurekaKosikApiBundle::class => ['all' => true]
 *
 * 2. Configure in config/packages/heureka_kosik_api.yaml:
 *    heureka_kosik_api:
 *        api_key: '%env(HEUREKA_API_KEY)%'
 *        debug: false
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class HeurekaKosikApiBundle extends Bundle
{
    /**
     * Returns the bundle name
     */
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
