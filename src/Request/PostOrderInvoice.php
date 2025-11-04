<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI\Request;

use Freema\HeurekaAPI\Container;
use Freema\HeurekaAPI\HeurekaApiException;
use Freema\HeurekaAPI\IPostOrderInvoice;
use Freema\HeurekaAPI\Response;
use SplFileInfo;

/**
 * Zaslání poznámky, které obchod vytvořil při procesu vyřizování objednávky.
 * Tyto poznámky se zobrazují zákazníkovi u objednávky v jeho profilu.
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
class PostOrderInvoice extends Container implements IPostOrderInvoice
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

    public function setInvoiceFile(string $file): self
    {
        if (!file_exists($file)) {
            throw new HeurekaApiException('File does not exist!');
        }

        $fileInfo = new SplFileInfo($file);
        $ext = '.' . pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION);

        if ($ext !== '.pdf') {
            throw new HeurekaApiException('File is not pdf format!');
        }

        $this->param['invoice'] = '@' . $file . ';type=application/pdf';
        return $this;
    }

    public function execute(): Response
    {
        $response = $this->fileupload($this->url)->getResponse();

        if ($this->isError === true) {
            $response = null;
        }

        return new Response($response);
    }
}
