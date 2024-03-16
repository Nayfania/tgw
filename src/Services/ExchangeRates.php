<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ExchangeRates
{
    public function __construct(private readonly CacheInterface $cache)
    {
    }

    public function getByCurrency(string $code)
    {
        $rates = $this->cache->get('exchanges', function (ItemInterface $item): array {

            $item->expiresAfter(3600 * 24);

            $client = new Client([
                'base_uri' => 'https://api.apilayer.com/',
                'headers' => ['apikey' => 'GiAZvlMuKilho1M3Qgx1CjZv6o2bOZws']
            ]);
            $response = $client->get('exchangerates_data/latest');
            $content = json_decode($response->getBody()->getContents(), true);

            $item->set($content['rates']);

            return $item->get();
        });

        return $rates[$code];
    }
}