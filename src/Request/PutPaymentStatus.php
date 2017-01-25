<?php

namespace Freema\HeurekaAPI;

/**
 * Description of PutPaymentStatus
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class PutPaymentStatus extends GetPaymentStatus implements IPutPaymentStatus {

    /**
     * @param integer $id
     * @return \HeurekaAPI\PutPaymentStatus
     */
    public function setOrderId($id) {
        $this->_param['order_id'] = (int) $id;

        return $this;
    }

    /**
     * @param integer $status
     * @return \HeurekaAPI\PutPaymentStatus
     */
    public function setStatus($status) {
        $this->_param['status'] = (int) $status;

        return $this;
    }

    /**
     * @param string $date
     * @return \HeurekaAPI\PutPaymentStatus
     */
    public function setDate($date) {
        if ($date instanceof \DateTime) {
            $date = $date->format('Y-M-D');
        }

        $this->_param['date'] = (string) $date;

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
