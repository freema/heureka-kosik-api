<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Request;

use Freema\HeurekaAPI\Container;
use Freema\HeurekaAPI\HeurekaApiException;
use Freema\HeurekaAPI\IPostOrderNote;
use Freema\HeurekaAPI\Response;

/**
 * Zaslání poznámky, které obchod vytvořil při procesu vyřizování objednávky.
 * Tyto poznámky se zobrazují zákazníkovi u objednávky v jeho profilu.
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class PostOrderNote extends Container implements IPostOrderNote
{
    protected string $method = 'POST';

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

    public function setOrderId(int $id): self
    {
        $this->param['order_id'] = $id;
        return $this;
    }

    public function setNote(string $note): self
    {
        if (strlen($note) >= 1000) {
            throw new HeurekaApiException('Maximalni delka textu v poznamce muže byt jen 1000 znaků');
        }

        $this->param['note'] = $note;
        return $this;
    }

    public function execute(): Response
    {
        $response = $this->post($this->url, $this->param)->getResponse();

        if ($this->isError === true) {
            $response = null;
        }

        return new Response($response);
    }
}
