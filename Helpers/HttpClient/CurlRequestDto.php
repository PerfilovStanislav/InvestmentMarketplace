<?php

namespace Helpers\HttpClient;

class CurlRequestDto
{
    protected string $uri;

    protected array $uriParams = [];

    // дефолтные настройки
    protected array $curlParams = [
        CURLOPT_TIMEOUT => 10,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_ENCODING => 'gzip',
    ];

    public function __construct(
        string $uri,
        array $uriParams = [],
        array $headers = [],
        array $body = [],
        array $curlParams = [],
        bool $returnHeaders = false
    )
    {
        $this->uri = $uri;
        $this->uriParams = $uriParams;
        $this->curlParams[CURLOPT_HTTPHEADER] = $headers;
        $this->curlParams = \array_replace($this->curlParams, $curlParams);
        $this->curlParams[CURLOPT_HEADER] = $returnHeaders;

        if (empty($body) === false) {
            $this->curlParams[CURLOPT_POST] = 1;
            $this->curlParams[CURLOPT_POSTFIELDS] = $body;
        }
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getUriParams(): array
    {
        return $this->uriParams;
    }

    public function getCurlParams(): array
    {
        return $this->curlParams;
    }

    public function getCurlParam(string $key)
    {
        return $this->curlParams[$key];
    }

}
