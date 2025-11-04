<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Request;

use Freema\HeurekaAPI\Container;
use Freema\HeurekaAPI\IGetShopStatus;
use Freema\HeurekaAPI\Response;

/**
 * Informace o aktivaci obchodu v Košíku.
 * Slouží k zjištění zda je obchod spuštěn v Košíku či nikoliv.
 * Pokud je Košík vypnutý z důvodu chyby v API nebo nějaké procesní chyby,
 * je o tom napsáno v parametru message.
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class GetShopStatus extends Container implements IGetShopStatus
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

    public function execute(): Response
    {
        $response = $this->get($this->url)->getResponse();

        if ($this->isError === true) {
            $response = null;
        }

        return new Response($response);
    }
}
