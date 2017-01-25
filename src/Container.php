<?php

namespace Freema\HeurekaAPI;

/**
 * Description of Container
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
abstract class Container implements IContainer {

    /** curl_init() */
    protected $request;

    /** @var mix */
    protected $response;

    /** @var array */
    private $_decodet;

    /** @var string */
    protected $_url;

    /** @var array */
    protected $_param;

    /** @var integer */
    private $_httpCode;

    /** @var bool */
    protected $_isError = FALSE;

    /** @var array */
    protected $_errorMessage = NULL;

    protected function get($url, $vars = array()) {
        if (!empty($vars)) {
            $url .= (stripos($url, '?') !== false) ? '&' : '?';
            $url .= (is_string($vars)) ? $vars : http_build_query($vars, '', '&');
        }
        return $this->request('GET', $url);
    }

    protected function head($url, $vars = array()) {
        return $this->request('HEAD', $url, $vars);
    }

    protected function post($url, $vars = array()) {
        return $this->request('POST', $url, $vars);
    }

    protected function put($url, $vars = array()) {
        return $this->request('PUT', $url, $vars);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $vars
     * @return \HeurekaAPI\Container
     */
    protected function request($method, $url, $vars = array()) {
        $this->error = '';
        $this->request = curl_init();

        if (is_array($vars))
            $vars = http_build_query($vars, '', '&');

        $this->set_request_method($method, $vars);
        $this->set_request_options($url);

        $response = curl_exec($this->request);
        $this->_httpCode = curl_getinfo($this->request, CURLINFO_HTTP_CODE);

        $this->response = $response;

        curl_close($this->request);
        return $this;
    }

    /**
     * @param string $method
     * @param string $vars
     */
    protected function set_request_method($method, $vars) {
        switch (strtoupper($method)) {
            case 'HEAD':
                curl_setopt($this->request, CURLOPT_NOBODY, true);
                break;
            case 'GET':
                curl_setopt($this->request, CURLOPT_HTTPGET, true);
                break;
            case 'POST':
                curl_setopt($this->request, CURLOPT_POST, true);
                curl_setopt($this->request, CURLOPT_POSTFIELDS, $vars);
                break;
            case 'PUT':
                curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($this->request, CURLOPT_POSTFIELDS, $vars);
            default:
                curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, $method);
        }
    }

    protected function fileupload($url) {
        $this->request = curl_init();

        curl_setopt($this->request, CURLOPT_URL, $url);
        curl_setopt($this->request, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->request, CURLOPT_POST, true);
        curl_setopt($this->request, CURLOPT_POSTFIELDS, $this->_param);

        $this->response = curl_exec($this->request);
        curl_close($this->request);

        return $this;
    }

    /**
     * @return array
     */
    protected function getResponse() {
        $this->_decodet = json_decode($this->response, true);
        $this->_checkError();

        return $this->_decodet;
    }

    private function _checkError() {
        if ($this->_httpCode >= 400) {
            $this->_isError = TRUE;
            $this->_errorMessage = $this->_decodet;
        }
    }

    /**
     * @return bool
     */
    public function hasError() {
        return $this->_isError;
    }

    /**
     * @return array
     */
    public function getErrorMessage() {
        return $this->_errorMessage;
    }

    /**
     * @param string $url
     * @param string $vars
     */
    protected function set_request_options($url) {
        curl_setopt($this->request, CURLOPT_URL, $url);
        curl_setopt($this->request, CURLOPT_RETURNTRANSFER, TRUE);
    }

}
