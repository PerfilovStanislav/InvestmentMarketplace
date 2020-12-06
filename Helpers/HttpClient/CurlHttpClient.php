<?php

namespace Helpers\HttpClient;

class CurlHttpClient
{
    protected CurlRequestDto $request;

    protected function setRequest(CurlRequestDto $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function get(CurlRequestDto $request): CurlResponseDto
    {
        return $this->setRequest($request)->request('GET');
    }

    public function post(CurlRequestDto $request): CurlResponseDto
    {
        return $this->setRequest($request)->request('POST');
    }

    public function request(string $method): CurlResponseDto
    {
        \set_time_limit(300);
        $fullUri = $this->request->getUri()
            . (
            $this->request->getUriParams()
                ? \http_build_query($this->request->getUriParams())
                : ''
            );
        $ch = \curl_init();
        \curl_setopt_array($ch, \array_replace([
            CURLOPT_URL => $fullUri,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_COOKIEJAR => $_SERVER['DOCUMENT_ROOT'].'/cookiefile.txt',
            CURLOPT_TIMEOUT => 300,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36',
        ], $this->request->getCurlParams()));

        $raw = \curl_exec($ch);

        if ($this->request->getCurlParam(CURLOPT_HEADER)) {
            // Если запрашивали заголовки, то парсим их
            $headers_size = \curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = $this->parseHeaders(substr($raw, 0, $headers_size));
            $rawBody = \substr($raw, $headers_size);
        } else {
            $headers = [];
            $rawBody = $raw;
        }
        $status = \curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $response = new CurlResponseDto($rawBody ?? '', $status, $headers, \curl_error($ch));

        \curl_close($ch);

        return $response;
    }

    /**
     * парсит заголовик ответа в массив
     * @param string $headers
     * @return array
     */
    public function parseHeaders(string $headers): array
    {
        $strings = \explode("\r", $headers);
        $result = [];
        foreach ($strings as $string) {
            if (($pos = \strpos($string, ': ')) !== false) {
                $result[\trim(\substr($string, 0, $pos))] =
                    \trim(\substr($string, $pos + 2));
            }
        }

        return $result;
    }

}
