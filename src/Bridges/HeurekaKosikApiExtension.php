<?php
namespace Freema\HeurekaAPI\Bridges;

use Freema\HeurekaAPI\Api;

class HeurekaKosikApiExtension extends \Nette\DI\CompilerExtension {

    public function loadConfiguration() {
        $container = $this->getContainerBuilder();
        $config = $this->getConfig();
       
        if(!isset($config['key'])) {
            $key = Api::VALID_API_KEY;
        }else{
            $key = $config['key'];
        }
        
        $container  ->addDefinition($this->prefix('HeurekaKosikApi'))
                    ->setClass('Freema\HeurekaAPI\Api', $key)
                    ->setAutowired(isset($config['autowired']) ? $config['autowired'] : TRUE);
    }
}
