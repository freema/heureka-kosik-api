<?php

namespace Freema\HeurekaAPI;

use InvalidArgumentException;
use OverflowException;
use UnexpectedValueException;

/**
 * Description of HeurekaApi
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class Api {

    /**
     * Heureka endpoint URL
     * 
     * @var string
     */
    const BASE_URL = 'https://ssl.heureka.cz/api/cart/';

    /**
     * Shop API key
     * 
     * @var string
     */
    private $_apiKey;

    /**
     * API version
     * 
     * @var integer
     */
    private $_apiVersion = 1;

    /**
     * @var bool
     */
    private $_debugMode = FALSE;

    /**
     * Heureka Api container
     * 
     * @var IContainer 
     */
    private $_container;

    const VALID_API_KEY = 'validate';

    /**
     * Initialize API service
     * 
     * @param string $apiKey
     */
    public function __construct($apiKey) {
        $this->setApiKey($apiKey);
    }

    /**
     * Sets API key and check well-formedness
     * 
     * @param string $apiKey
     * @throws OverflowException
     */
    public function setApiKey($apiKey) {
        if ($apiKey === self::VALID_API_KEY) {
            $this->_apiKey = $apiKey;
            $this->_debugMode = TRUE;
            return $this;
        }

        if (preg_match('(^[0-9abcdef]{32}$)', $apiKey)) {
            $this->_apiKey = $apiKey;
            return $this;
        } else {
            throw new UnexpectedValueException('Invalid api key "' . $apiKey . '".');
        }
    }

    /**
     * verze API, která je využívána (momentálně verze 1)
     * 
     * @param integer $version
     */
    public function setApiVersion($version) {
        if (is_integer($version)) {
            $this->_apiVersion = $version;
            return $this;
        } else {
            throw new InvalidArgumentException('stApiVersion function only accepts integers. Input was:' . $version);
        }
    }

    /**
     * Heureka Api container
     * 
     * @return IContainer
     * @throws HeurekaApiException
     */
    public function getContainer() {
        if ($this->_container == NULL) {
            throw new HeurekaApiException('Container not set!');
        }

        return $this->_container;
    }

    /**
     * @return IGetPaymentStatus
     */
    public function getPaymentStatus() {
        $url = $this->_getUrl() . 'payment/status';
        $container = new GetPaymentStatus($url);
        return $this->_container = $container;
    }

    /**
     * Nastavení stavu platby na Heurece. 
     * Tato metoda slouží k nastavení platby při dobírce nebo platbě v hotovosti na pobočce obchodu
     * 
     * @return IPutPaymentStatus
     */
    public function putPaymentStatus() {
        $url = $this->_getUrl() . 'payment/status';
        $container = new PutPaymentStatus($url);
        return $this->_container = $container;
    }

    /**
     * Informace o stavu objednávky a interním čísle objednávky na Heurece.
     * 
     * @return IGetOrderStatus
     */
    public function getOrderStatus() {
        $url = $this->_getUrl() . 'order/status';
        $container = new GetOrderStatus($url);
        return $this->_container = $container;
    }

    /**
     * Nastavení stavu objednávy na Heurece. 
     * Je důležité, aby každá změna objednávky byla přenesena zpět do Heureky.
     * Jenom tak je možné zákazníkům zobrazit v jakém stavu se nachází jejich objednávka. 
     * 
     * @return IPutOrderStatus
     */
    public function putOrderStatus() {
        $url = $this->_getUrl() . 'order/status';
        $container = new PutOrderStatus($url);
        return $this->_container = $container;
    }

    /**
     * Informace o pobočkách / výdejních místech, které má obchod uložené na Heurece. 
     * Slouží k nastavení store v GET payment/delivery <http://sluzby.heureka.cz/napoveda/kosik-api/#pd-tabs>.
     * 
     * @return IGetStores 
     */
    public function getStores() {
        $url = $this->_getUrl() . 'stores';
        $container = new GetStores($url);
        return $this->_container = $container;
    }

    /**
     *  Informace o aktivaci obchodu v Košíku.
     *  Slouží k zjištění zda je obchod spuštěn v Košíku či nikoliv.
     *  Pokud je Košík vypnutý z důvodu chyby v API nebo nějaké procesní chyby, 
     *  je o tom napsáno v parametru message. 
     * 
     * @return IGetShopStatus
     */
    public function getShopStatus() {
        $url = $this->_getUrl() . 'shop/status';
        $container = new GetShopStatus($url);
        return $this->_container = $container;
    }

    /**
     * Zaslání poznámky, které obchod vytvořil při procesu vyřizování objednávky.
     * Tyto poznámky se zobrazují zákazníkovi u objednávky v jeho profilu.
     * @return IPostOrderNote
     */
    public function postOrderNote() {
        $url = $this->_getUrl() . 'order/note';
        $container = new PostOrderNote($url);
        return $this->_container = $container;
    }

    /**
     *  Zaslaní faktury (dokladu) k objednávce.
     *  Obchody, které posílají faktury zákazníkům v elektronické podobě, ji musí zaslat také Heurece,
     *  tak aby je bylo možné opětovně poslat nebo umožnit jejich stažení v přehledu objednávek. 
     * 
     * @return IPostOrderInvoice
     */
    public function postOrderInvoice() {
        $url = $this->_getUrl() . 'order/invoice';
        $container = new PostOrderInvoice($url);
        return $this->_container = $container;
    }

    private function _getUrl() {
        if ($this->_debugMode == TRUE) {
            $url = 'http://api.heureka.cz/cart/' . $this->_apiKey . '/' . $this->_apiVersion . '/';
        } else {
            $url = HeurekaApi::BASE_URL . $this->_apiKey . '/' . $this->_apiVersion . '/';
        }

        return $url;
    }

}