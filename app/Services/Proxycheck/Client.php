<?php

declare(strict_types=1);

namespace App\Services\Proxycheck;

use App\Exceptions\ProxyCheckException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    /**
     * @var string
     */
    private string $apiKey;

    /**
     * @var string
     */
    private string $baseUrl;

    /**
     * @var GuzzleClient
     */
    private GuzzleClient $httpClient;

    /**
     * @param string $apiKey
     * @param string $baseUrl
     */
    public function __construct(string $apiKey, string $baseUrl)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
        $this->httpClient = new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'query' => ['key' => $this->apiKey],
        ]);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $params
     * @return array
     * @throws GuzzleException
     * @throws ProxyCheckException
     */
    public function request(string $method, string $uri, array $params = []): array
    {
        $response = $this->httpClient->request($method, $uri, $params);

        $content = json_decode($response->getBody()->getContents(), true);

        if ($content['status'] === 'error') {
            throw new ProxyCheckException($content['message']);
        }

        return $content;
    }
}
