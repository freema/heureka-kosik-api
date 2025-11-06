<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI;

use InvalidArgumentException;
use UnexpectedValueException;

/**
 * Description of HeurekaApi
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class Api
{
    /**
     * Heureka endpoint URL
     */
    private const BASE_URL = 'https://ssl.heureka.cz/api/cart/';

    /**
     * Heureka test endpoint URL
     */
    private const TEST_URL = 'http://api.heureka.cz/cart/test/';

    /**
     * Validation key
     */
    private const VALID_API_KEY = 'validate';

    /**
     * Shop API key
     */
    private string $apiKey;

    /**
     * API version
     */
    private int $apiVersion = 1;

    private bool $debugMode = false;

    /**
     * Heureka Api container
     */
    private ?IContainer $container = null;

    /**
     * Initialize API service
     */
    public function __construct(string $apiKey, bool $debug = false)
    {
        $this->setApiKey($apiKey, $debug);
    }

    /**
     * Sets API key and check well-formedness
     *
     * @throws UnexpectedValueException
     */
    public function setApiKey(string $apiKey, bool $debug = false): self
    {
        if ($apiKey === self::VALID_API_KEY) {
            $this->apiKey = $apiKey;
            $this->debugMode = false;
            return $this;
        }

        if (preg_match('(^[\w]{7}$)', $apiKey) === 1) {
            $this->apiKey = $apiKey;
            $this->debugMode = $debug;
            return $this;
        }

        throw new UnexpectedValueException('Invalid api key "' . $apiKey . '".');
    }

    /**
     * Set API version (currently version 1)
     */
    public function setApiVersion(int $version): self
    {
        $this->apiVersion = $version;
        return $this;
    }

    /**
     * Get Heureka Api container
     *
     * @throws HeurekaApiException
     */
    public function getContainer(): IContainer
    {
        if ($this->container === null) {
            throw new HeurekaApiException('Container not set!');
        }

        return $this->container;
    }

    public function getPaymentStatus(): IGetPaymentStatus
    {
        $url = $this->getUrl() . 'payment/status';
        $container = new Request\GetPaymentStatus($url);
        return $this->container = $container;
    }

    /**
     * Nastavení stavu platby na Heurece.
     * Tato metoda slouží k nastavení platby při dobírce nebo platbě v hotovosti na pobočce obchodu
     */
    public function putPaymentStatus(): IPutPaymentStatus
    {
        $url = $this->getUrl() . 'payment/status';
        $container = new Request\PutPaymentStatus($url);
        return $this->container = $container;
    }

    /**
     * Informace o stavu objednávky a interním čísle objednávky na Heurece.
     */
    public function getOrderStatus(): IGetOrderStatus
    {
        $url = $this->getUrl() . 'order/status';
        $container = new Request\GetOrderStatus($url);
        return $this->container = $container;
    }

    /**
     * Nastavení stavu objednávy na Heurece.
     * Je důležité, aby každá změna objednávky byla přenesena zpět do Heureky.
     * Jenom tak je možné zákazníkům zobrazit v jakém stavu se nachází jejich objednávka.
     */
    public function putOrderStatus(): IPutOrderStatus
    {
        $url = $this->getUrl() . 'order/status';
        $container = new Request\PutOrderStatus($url);
        return $this->container = $container;
    }

    /**
     * Informace o pobočkách / výdejních místech, které má obchod uložené na Heurece.
     * Slouží k nastavení store v GET payment/delivery <http://sluzby.heureka.cz/napoveda/kosik-api/#pd-tabs>.
     */
    public function getStores(): IGetStores
    {
        $url = $this->getUrl() . 'stores';
        $container = new Request\GetStores($url);
        return $this->container = $container;
    }

    /**
     * Informace o aktivaci obchodu v Košíku.
     * Slouží k zjištění zda je obchod spuštěn v Košíku či nikoliv.
     * Pokud je Košík vypnutý z důvodu chyby v API nebo nějaké procesní chyby,
     * je o tom napsáno v parametru message.
     */
    public function getShopStatus(): IGetShopStatus
    {
        $url = $this->getUrl() . 'shop/status';
        $container = new Request\GetShopStatus($url);
        return $this->container = $container;
    }

    /**
     * Zaslání poznámky, které obchod vytvořil při procesu vyřizování objednávky.
     * Tyto poznámky se zobrazují zákazníkovi u objednávky v jeho profilu.
     */
    public function postOrderNote(): IPostOrderNote
    {
        $url = $this->getUrl() . 'order/note';
        $container = new Request\PostOrderNote($url);
        return $this->container = $container;
    }

    /**
     * Zaslaní faktury (dokladu) k objednávce.
     * Obchody, které posílají faktury zákazníkům v elektronické podobě, ji musí zaslat také Heurece,
     * tak aby je bylo možné opětovně poslat nebo umožnit jejich stažení v přehledu objednávek.
     */
    public function postOrderInvoice(): IPostOrderInvoice
    {
        $url = $this->getUrl() . 'order/invoice';
        $container = new Request\PostOrderInvoice($url);
        return $this->container = $container;
    }

    private function getUrl(): string
    {
        if ($this->debugMode === true) {
            return self::TEST_URL . $this->apiKey;
        }

        return self::BASE_URL . $this->apiKey . '/' . $this->apiVersion . '/';
    }
}
