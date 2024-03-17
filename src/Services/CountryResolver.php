<?php

namespace App\Services;

use App\Services\Interfaces\CountryResolverInterface;
use GuzzleHttp\Client;

class CountryResolver implements CountryResolverInterface
{
    public function byBIN(string $bin): string
    {
        $client = new Client(['base_uri' => 'https://lookup.binlist.net/']);
        $response = $client->get($bin);

        $lookup = json_decode($response->getBody()->getContents());

        return $lookup->country->alpha2;
    }

    public function isEu(string $bin): bool
    {
        $countryCode = $this->byBIN($bin);
        return match ($countryCode) {
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK' => true,
            default => false,
        };
    }
}