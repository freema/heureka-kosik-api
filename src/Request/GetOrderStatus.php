<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Request;

use Freema\HeurekaAPI\Container;
use Freema\HeurekaAPI\IGetOrderStatus;
use Freema\HeurekaAPI\Response;

/**
 * Description of GetOrderStatus
 * Informace o stavu objednávky a interním čísle objednávky na Heurece.
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class GetOrderStatus extends Container implements IGetOrderStatus
{
    protected string $method = 'GET';

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * ID objednávky
     */
    public function setOrderId(int $id): self
    {
        $this->param['order_id'] = $id;
        return $this;
    }

    public function execute(): Response
    {
        $response = $this->get($this->url, $this->param)->getResponse();

        if ($this->isError === true) {
            $response = null;
        }

        return new Response($response);
    }
}
