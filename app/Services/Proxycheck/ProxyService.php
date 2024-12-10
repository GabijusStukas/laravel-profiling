<?php

declare(strict_types=1);

namespace App\Services\Proxycheck;

use App\Exceptions\ProxyCheckException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProxyService
{
    /**
     * @param Client $client
     */
    public function __construct(private Client $client)
    {
    }

    /**
     * @param string $ip
     * @return bool
     */
    public function isProxy(string $ip): bool
    {
        try {
            $proxyDetails = $this->getProxyDetails($ip);

            if (empty($proxyDetails)) {
                return false;
            }

            return $proxyDetails[$ip]['proxy'] === 'yes';
        } catch (Throwable $exception) {
            Log::error('ProxyService: failed to check proxy', [
                'error' => $exception->getMessage(),
                'ip' => $ip,
            ]);
            return false;
        }
    }

    /**
     * @param string $ip
     * @return string|null
     */
    public function getCountryByIpAddress(string $ip): ?string
    {
        try {
            $proxyDetails = $this->getProxyDetails($ip);

            if (empty($proxyDetails)) {
                return null;
            }

            return $proxyDetails[$ip]['country'];
        } catch (Throwable $exception) {
            Log::error('ProxyService: failed to get country', [
                'error' => $exception->getMessage(),
                'ip' => $ip,
            ]);
            return null;
        }
    }

    /**
     * @param string $ip
     * @return array
     */
    private function getProxyDetails(string $ip): array
    {
        return Cache::remember("proxy_check_$ip", now()->addMinutes(10), function () use ($ip) {
            try {
                Log::info('ProxyService: getting proxy details', ['ip' => $ip]);

                return $this->client->request('GET', $ip, [
                    'query' => [
                        'ip' => $ip,
                        'asn' => 1
                    ],
                ]);
            } catch (GuzzleException|ProxyCheckException $exception) {
                Log::error('ProxyService: failed to get proxy details', [
                    'error' => $exception->getMessage(),
                    'ip' => $ip,
                ]);

                return [];
            }
        });
    }
}
