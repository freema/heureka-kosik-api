<?php

namespace Freema\HeurekaAPI;

/**
 * Description of GetOrderStatus
 * Informace o stavu objednávky a interním čísle objednávky na Heurece. 
 * 
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class GetOrderStatus extends Container implements IGetOrderStatus {

    /**
     * @var string
     */
    protected $_url;

    /**
     * @var array
     */
    protected $_param;

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
     * ID objednávky
     * 
     * @param integer $id
     * @return \HeurekaAPI\PutOrderStatus
     */
    public function setOrderId($id) {
        $this->_param['order_id'] = (int) $id;

        return $this;
    }

    /**
     * @return \Response
     */
    public function execute() {

        $response = $this->get($this->_url, $this->_param)->getResponse();

        if ($this->_isError == TRUE) {
            $response = NULL;
        }

        $return = new Response($response);

        return $return;
    }

}
