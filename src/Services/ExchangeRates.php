<?php

namespace App\Services;

use App\Services\Interfaces\ExchangeRatesInterface;
use GuzzleHttp\Client;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ExchangeRates implements ExchangeRatesInterface
{
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly string         $uri,
        private readonly string         $apiKey
    )
    {
    }

    public function getByCurrency(string $code)
    {
        $rates = $this->cache->get('exchanges', function (ItemInterface $item): array {

            $item->expiresAfter(3600 * 24);

            $client = new Client([
                'base_uri' => $this->uri,
                'headers' => ['apikey' => $this->apiKey]
            ]);
            $response = $client->get('exchangerates_data/latest');
            $content = json_decode($response->getBody()->getContents(), true);

            $item->set($content['rates']);

            return $item->get();
        });

        return $rates[$code];
    }
}