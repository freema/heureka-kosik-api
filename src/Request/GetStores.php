<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Request;

use Freema\HeurekaAPI\Container;
use Freema\HeurekaAPI\IGetStores;
use Freema\HeurekaAPI\Response;

/**
 * Description of GetStore
 *
 * Informace o pobočkách / výdejních místech, které má obchod uložené na Heurece.
 * Slouží k nastavení store v GET payment/delivery <http://sluzby.heureka.cz/napoveda/kosik-api/#pd-tabs>.
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class GetStores extends Container implements IGetStores
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

    public function execute(): Response
    {
        $response = $this->get($this->url)->getResponse();

        if ($this->isError === true) {
            $response = null;
        }

        return new Response($response);
    }
}
