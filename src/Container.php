<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI;

use CurlHandle;

/**
 * Description of Container
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
abstract class Container implements IContainer
{
    protected ?CurlHandle $request = null;

    protected mixed $response = null;

    /**
     * @var array<string, mixed>|null
     */
    private ?array $decoded = null;

    protected string $url;

    /**
     * @var array<string, mixed>
     */
    protected array $param = [];

    private int $httpCode = 0;

    protected bool $isError = false;

    /**
     * @var array<string, mixed>|null
     */
    protected ?array $errorMessage = null;

    /**
     * @param array<string, mixed> $vars
     */
    protected function get(string $url, array $vars = []): self
    {
        if ($vars !== []) {
            $url .= (stripos($url, '?') !== false) ? '&' : '?';
            $url .= http_build_query($vars, '', '&');
        }
        return $this->request('GET', $url);
    }

    /**
     * @param array<string, mixed> $vars
     */
    protected function head(string $url, array $vars = []): self
    {
        return $this->request('HEAD', $url, $vars);
    }

    /**
     * @param array<string, mixed> $vars
     */
    protected function post(string $url, array $vars = []): self
    {
        return $this->request('POST', $url, $vars);
    }

    /**
     * @param array<string, mixed> $vars
     */
    protected function put(string $url, array $vars = []): self
    {
        return $this->request('PUT', $url, $vars);
    }

    /**
     * @param array<string, mixed> $vars
     */
    protected function request(string $method, string $url, array $vars = []): self
    {
        $curlHandle = curl_init();

        if (!$curlHandle instanceof \CurlHandle) {
            throw new HeurekaApiException('Failed to initialize cURL');
        }

        $this->request = $curlHandle;
        $varsString = http_build_query($vars, '', '&');

        $this->setRequestMethod($method, $varsString);
        $this->setRequestOptions($url);

        $response = curl_exec($curlHandle);
        $httpCodeResult = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        $this->httpCode = $httpCodeResult;

        $this->response = $response;

        curl_close($curlHandle);
        $this->request = null;
        return $this;
    }

    protected function setRequestMethod(string $method, string $vars): void
    {
        if ($this->request === null) {
            throw new HeurekaApiException('cURL handle is not initialized');
        }

        switch (strtoupper($method)) {
            case 'HEAD':
                curl_setopt($this->request, CURLOPT_NOBODY, true);
                break;
            case 'GET':
                curl_setopt($this->request, CURLOPT_HTTPGET, true);
                break;
            case 'POST':
                curl_setopt($this->request, CURLOPT_POST, true);
                curl_setopt($this->request, CURLOPT_POSTFIELDS, $vars);
                break;
            case 'PUT':
                curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($this->request, CURLOPT_POSTFIELDS, $vars);
                break;
            default:
                curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, $method);
        }
    }

    protected function fileupload(string $url): self
    {
        $curlHandle = curl_init();

        if (!$curlHandle instanceof \CurlHandle) {
            throw new HeurekaApiException('Failed to initialize cURL');
        }

        $this->request = $curlHandle;

        curl_setopt($this->request, CURLOPT_URL, $url);
        curl_setopt($this->request, CURLOPT_HTTPHEADER, ['Content-type: multipart/form-data']);
        curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->request, CURLOPT_POST, true);
        curl_setopt($this->request, CURLOPT_POSTFIELDS, $this->param);

        $this->response = curl_exec($this->request);
        curl_close($this->request);

        return $this;
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function getResponse(): ?array
    {
        $responseString = is_string($this->response) ? $this->response : '';
        $decoded = json_decode($responseString, true);
        $this->decoded = is_array($decoded) ? $decoded : null;
        $this->checkError();

        return $this->decoded;
    }

    private function checkError(): void
    {
        if ($this->httpCode >= 400) {
            $this->isError = true;
            $this->errorMessage = $this->decoded;
        }
    }

    public function hasError(): bool
    {
        return $this->isError;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getErrorMessage(): ?array
    {
        return $this->errorMessage;
    }

    protected function setRequestOptions(string $url): void
    {
        if ($this->request === null) {
            throw new HeurekaApiException('cURL handle is not initialized');
        }

        curl_setopt($this->request, CURLOPT_URL, $url);
        curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
    }
}
