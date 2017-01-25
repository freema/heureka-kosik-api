<?php
namespace Freema\HeurekaAPI\Bridges;

use Freema\HeurekaAPI\Api;

class HeurekaKosikApiExtension extends \Nette\DI\CompilerExtension {

    /**
     * @return void
     */
    public function loadConfiguration() {
        $container = $this->getContainerBuilder();
        $config = $this->getConfig();
       
        if(!isset($config['key'])) {
            $config['key'] = Api::VALID_API_KEY;
        }
        if(!isset($config['debug'])) {
            $config['debug'] = TRUE;
        }
        
        $container  ->addDefinition($this->prefix('HeurekaKosikApi'))
                    ->setClass('Freema\HeurekaAPI\Api', array('apiKey' => $config['key'], 'debug' => $config['debug']))
                    ->setAutowired(isset($config['autowired']) ? $config['autowired'] : TRUE);
    }
}