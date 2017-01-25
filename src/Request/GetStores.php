<?php

namespace Freema\HeurekaAPI;

/**
 * Description of GetStore
 * 
 * Informace o pobočkách / výdejních místech, které má obchod uložené na Heurece. 
 * Slouží k nastavení store v GET payment/delivery <http://sluzby.heureka.cz/napoveda/kosik-api/#pd-tabs>. 
 * 
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class GetStores extends Container implements IGetStores {

    /**
     * @var string
     */
    protected $_url;

    /**
     * @var string
     */
    protected $_method = 'GET';

    /**
     * @param string $url
     */
    function __construct($url) {
        $this->_url = $url;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->_url;
    }

    /**
     * @param string $method
     * @return \HeurekaAPI\GetStores
     */
    public function setMethod($method) {
        $this->_method = $method;
        return $this;
    }

    /**
     * @return Response
     */
    public function execute() {
        $response = $this->get($this->_url)->getResponse();

        if ($this->_isError == TRUE) {
            $response = NULL;
        }

        return new Response($response);
    }

}
