<?php

namespace HeurekaAPI;

/**
 * Description of order/status api
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class PutOrderStatus extends GetOrderStatus implements IPutOrderStatus {

    /**
     * @param integer $id
     * @return \HeurekaAPI\PutOrderStatus
     */
    public function setOrderId($id) {
        $this->_param['order_id'] = (int) $id;

        return $this;
    }

    /**
     * @param integer $status
     * @return \HeurekaAPI\PutOrderStatus
     */
    public function setStatus($status) {
        $this->_param['status'] = (int) $status;

        return $this;
    }

    /**
     * @param string $url
     * @return \HeurekaAPI\PutOrderStatus
     */
    public function setTracnkingUrl($url) {
        $this->_param['transport']['tracnking_url'] = (string) $url;

        return $this;
    }

    /**
     * @param string $note
     * @return \HeurekaAPI\PutOrderStatus
     */
    public function setNote($note) {
        $this->_param['transport']['note'] = (string) $note;

        return $this;
    }

    /**
     * @param string $delivary
     * @return \HeurekaAPI\PutOrderStatus
     */
    public function setExpectDeliver($delivary) {
        $this->_param['transport']['note'] = (string) $delivary;

        return $this;
    }

    /**
     * @return Response
     */
    public function execute() {

        $response = $this->put($this->_url, $this->_param)->getResponse();

        if ($this->_isError == TRUE) {
            $response = NULL;
        }

        return new Response($response);
    }

}
