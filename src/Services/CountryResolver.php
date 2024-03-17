<?php

namespace App\Services;

use App\Services\Interfaces\CountryResolverInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CountryResolver implements CountryResolverInterface
{
    public function __construct(private readonly string $uri)
    {
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function byBIN(string $bin): string
    {
        $client = new Client(['base_uri' => $this->uri]);
        $response = $client->get($bin);

        $lookup = json_decode($response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);

        return $lookup->country->alpha2;
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function isEu(string $bin): bool
    {
        $countryCode = $this->byBIN($bin);

        return match ($countryCode) {
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK' => true,
            default => false,
        };
    }
}