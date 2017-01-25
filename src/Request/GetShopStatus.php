<?php

namespace HeurekaAPI;

/**
 *  Informace o aktivaci obchodu v Košíku.
 *  Slouží k zjištění zda je obchod spuštěn v Košíku či nikoliv.
 *  Pokud je Košík vypnutý z důvodu chyby v API nebo nějaké procesní chyby,
 *  je o tom napsáno v parametru message. 
 * 
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class GetShopStatus extends Container implements IGetShopStatus {

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
     * @return \HeurekaAPI\GetOrderStatus
     */
    public function setMethod($method) {
        $this->_method = $method;
        return $this;
    }

    /**
     * @param string $url
     * @return \HeurekaAPI\PutOrderStatus
     */
    public function setUrl($url) {
        $this->_url = (string) $url;
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

        $return = new Response($response);

        return $return;
    }

}
