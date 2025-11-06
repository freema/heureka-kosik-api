<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Request;

use Freema\HeurekaAPI\IPutOrderStatus;
use Freema\HeurekaAPI\Response;

/**
 * Description of order/status api
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class PutOrderStatus extends GetOrderStatus implements IPutOrderStatus
{
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

    public function setTracnkingUrl(string $url): self
    {
        if (!isset($this->param['transport']) || !is_array($this->param['transport'])) {
            $this->param['transport'] = [];
        }
        $this->param['transport']['tracnking_url'] = $url;
        return $this;
    }

    public function setNote(string $note): self
    {
        if (!isset($this->param['transport']) || !is_array($this->param['transport'])) {
            $this->param['transport'] = [];
        }
        $this->param['transport']['note'] = $note;
        return $this;
    }

    public function setExpectDeliver(string $delivary): self
    {
        // BUGFIX: This was incorrectly setting 'note' instead of 'expect_deliver'
        if (!isset($this->param['transport']) || !is_array($this->param['transport'])) {
            $this->param['transport'] = [];
        }
        $this->param['transport']['expect_deliver'] = $delivary;
        return $this;
    }

    public function execute(): Response
    {
        $response = $this->put($this->url, $this->param)->getResponse();

        if ($this->isError === true) {
            $response = null;
        }

        return new Response($response);
    }
}
