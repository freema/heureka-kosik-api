<?php

namespace HeurekaAPI;

/**
 * Zaslání poznámky, které obchod vytvořil při procesu vyřizování objednávky.
 * Tyto poznámky se zobrazují zákazníkovi u objednávky v jeho profilu. 
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class PostOrderInvoice extends Container implements IPostOrderInvoice {

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
     * @return \HeurekaAPI\PostOrderInvoice
     */
    public function setMethod($method) {
        $this->_method = $method;
        return $this;
    }

    /**
     * @param integer $id
     * @return \HeurekaAPI\PostOrderInvoice
     */
    public function setOrderId($id) {
        $this->_param['order_id'] = (int) $id;

        return $this;
    }

    /**
     * @param string $file
     * @return \HeurekaAPI\PostOrderInvoice
     */
    public function setInvoiceFile($file) {
        if (!file_exists($file)) {
            throw new HeurekaApiException('File does not exist!');
        }

        $fileInfo = new \SplFileInfo($file);
        $ext = '.' . pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION);

        if (!$ext == '.pdf') {
            throw new HeurekaApiException('File is not pdf format!');
        }

        $this->_param['invoice'] = '@' . $file . ';type=application/pdf';

        return $this;
    }

    /**
     * @return Response
     */
    public function execute() {
        $response = $this->fileupload($this->_url, $this->_param)->getResponse();

        if ($this->_isError == TRUE) {
            $response = NULL;
        }

        return new Response($response);
    }

}
