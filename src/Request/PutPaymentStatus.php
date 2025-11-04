<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Request;

use DateTime;
use Freema\HeurekaAPI\IPutPaymentStatus;
use Freema\HeurekaAPI\Response;

/**
 * Description of PutPaymentStatus
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class PutPaymentStatus extends GetPaymentStatus implements IPutPaymentStatus
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

    public function setDate(string|DateTime $date): self
    {
        if ($date instanceof DateTime) {
            $date = $date->format('Y-m-d');
        }

        $this->param['date'] = $date;
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
