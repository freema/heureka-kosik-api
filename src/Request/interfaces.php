<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI;

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IGetOrderStatus
{
    /**
     * ID objednávky
     */
    public function setOrderId(int $id): self;

    public function execute(): Response;
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IGetPaymentStatus
{
    public function setOrderId(int $id): self;

    public function execute(): Response;
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IGetShopStatus
{
    public function execute(): Response;
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IGetStores
{
    public function execute(): Response;
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IPostOrderInvoice
{
    public function setOrderId(int $id): self;

    public function setInvoiceFile(string $file): self;

    public function execute(): Response;
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IPostOrderNote
{
    public function setOrderId(int $id): self;

    public function setNote(string $note): self;

    public function execute(): Response;
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IPutOrderStatus
{
    public function setOrderId(int $id): self;

    public function setStatus(int $status): self;

    public function setTracnkingUrl(string $url): self;

    public function setNote(string $note): self;

    public function setExpectDeliver(string $delivary): self;

    public function execute(): Response;
}

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IPutPaymentStatus
{
    public function setOrderId(int $id): self;

    public function setStatus(int $status): self;

    public function setDate(string $date): self;

    public function execute(): Response;
}
