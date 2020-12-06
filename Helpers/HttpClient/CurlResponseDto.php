<?php

namespace Helpers\HttpClient;

class CurlResponseDto
{
    protected string $rawBody;
    protected array $jsonBody;
    protected int $status;
    protected string $error;
    protected array $headers = [];

    public function __construct(string $rawBody, int $status, array $headers, string $error)
    {
        $this->headers = $headers;
        $this->rawBody = $rawBody;
        $this->status = $status;
        $this->error = $error;
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function getRawBody(): string
    {
        return $this->rawBody;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeaderLine(string $key)
    {
        return $this->headers[$key] ?? null;
    }

    public function getJsonBody()
    {
        if ($this->jsonBody) {
            return $this->jsonBody;
        }

        $data = \json_decode($this->rawBody, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('json_decode error: ' . json_last_error_msg());
        }

        return $this->jsonBody = $data;
    }

    public function getError()
    {
        return $this->error;
    }

}
