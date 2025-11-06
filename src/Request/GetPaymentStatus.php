<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Request;

use Freema\HeurekaAPI\Container;
use Freema\HeurekaAPI\IGetPaymentStatus;
use Freema\HeurekaAPI\Response;

/**
 * Description of payment_status
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class GetPaymentStatus extends Container implements IGetPaymentStatus
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

    public function setOrderId(int $id): self
    {
        $this->param['order_id'] = $id;
        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->param['status'] = $status;
        return $this;
    }

    public function setDate(string $date): self
    {
        $this->param['date'] = $date;
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
