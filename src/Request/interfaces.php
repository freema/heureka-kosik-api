<?php

namespace Freema\HeurekaAPI;

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IGetOrderStatus {

    /**
     * ID objednávky
     * 
     * @param integer $id
     * @return IGetOrderStatus
     */
    function setOrderId($id);

    /**
     * @return Response
     */
    function execute();
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IGetPaymentStatus {

    /**
     * @param integer $id
     * @return IGetPaymentStatus
     */
    public function setOrderId($id);

    /**
     * @return Response
     */
    public function execute();
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IGetShopStatus {

    /**
     * @return Response
     */
    function execute();
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IGetStores {

    /**
     * @return Response
     */
    function execute();
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IPostOrderInvoice {

    /**
     * @param integer $id
     * @return IPostOrderInvoice
     */
    public function setOrderId($id);

    /**
     * @param string $file
     * @return IPostOrderInvoice
     */
    public function setInvoiceFile($file);

    /**
     * @return Response
     */
    public function execute();
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IPostOrderNote {

    /**
     * @param integer $id
     * @return IPostOrderNote
     */
    public function setOrderId($id);

    /**
     * @param string $status
     * @return IPostOrderNote
     */
    public function setNote($status);

    /**
     * @return Response
     */
    public function execute();
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IPutOrderStatus {

    /**
     * @param integer $id
     * @return IPutOrderStatus
     */
    function setOrderId($id);

    /**
     * @param integer $status
     * @return IPutOrderStatus
     */
    function setStatus($status);

    /**
     * @param string $url
     * @return IPutOrderStatus
     */
    function setTracnkingUrl($url);

    /**
     * @param string $note
     * @return IPutOrderStatus
     */
    function setNote($note);

    /**
     * @param string $delivary
     * @return IPutOrderStatus
     */
    function setExpectDeliver($delivary);

    /**
     * @return Response
     */
    function execute();
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IPutPaymentStatus {

    /**
     * @param integer $id
     * @return IPutPaymentStatus
     */
    public function setOrderId($id);

    /**
     * @param integer $status
     * @return IPutPaymentStatus
     */
    public function setStatus($status);

    /**
     * @param string $date
     * @return IPutPaymentStatus
     */
    public function setDate($date);

    /**
     * @return Response
     */
    public function execute();
}
