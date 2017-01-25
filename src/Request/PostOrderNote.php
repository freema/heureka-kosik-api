<?php

namespace Freema\HeurekaAPI;

/**
 * Zaslání poznámky, které obchod vytvořil při procesu vyřizování objednávky.
 * Tyto poznámky se zobrazují zákazníkovi u objednávky v jeho profilu. 
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class PostOrderNote extends Container implements IPostOrderNote {

    /**
     * @var string
     */
    protected $_url;

    /**
     * @var string
     */
    protected $_method = 'POST';

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
     * @return \HeurekaAPI\PostOrderNote
     */
    public function setMethod($method) {
        $this->_method = $method;
        return $this;
    }

    /**
     * @param integer $id
     * @return \HeurekaAPI\PostOrderNote
     */
    public function setOrderId($id) {
        $this->_param['order_id'] = (int) $id;

        return $this;
    }

    /**
     * @param string $note
     * @return \HeurekaAPI\PostOrderNote
     */
    public function setNote($note) {
        if (strlen($note) >= 1000) {
            throw new \HeurekaAPI\HeurekaApiException('Maximalni delka textu v poznamce muže byt jen 1000 znaků');
        }

        $this->_param['note'] = (string) $note;

        return $this;
    }

    /**
     * @return Response
     */
    public function execute() {
        $response = $this->post($this->_url, $this->_param)->getResponse();

        if ($this->_isError == TRUE) {
            $response = NULL;
        }

        return new Response($response);
    }

}
