<?php

namespace Freema\HeurekaAPI;

/**
 * Description of payment_status
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class GetPaymentStatus extends Container implements IGetPaymentStatus {

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
     * @param strign $url
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
     * @return \HeurekaAPI\GetPaymentStatus
     */
    public function setMethod($method) {
        $this->_method = $method;
        return $this;
    }

    /**
     * @param string $url
     * @return \HeurekaAPI\GetPaymentStatus
     */
    public function setUrl($url) {
        $this->_url = (string) $url;
        return $this;
    }

    /**
     * @param integer $id
     * @return \HeurekaAPI\GetPaymentStatus
     */
    public function setOrderId($id) {
        $this->_param['order_id'] = (int) $id;

        return $this;
    }

    /**
     * @param integer $status
     * @return \HeurekaAPI\GetPaymentStatus
     */
    public function setStatus($status) {
        $this->_param['status'] = (int) $status;

        return $this;
    }

    /**
     * @param string $date
     * @return \HeurekaAPI\GetPaymentStatus
     */
    public function setDate($date) {
        $this->_param['date'] = (string) $date;

        return $this;
    }

    /**
     * @return Response
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
