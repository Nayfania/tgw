<?php

namespace App\Services;

use App\Services\Interfaces\CountryResolverInterface;
use App\Services\Interfaces\ExchangeRatesInterface;

class CommissionManager
{
    public function __construct(
        private readonly CountryResolverInterface $countryResolver,
        private readonly ExchangeRatesInterface   $exchangeRates
    )
    {
    }

    public function calculate(array $rows): array
    {
        $result = [];
        foreach ($rows as $row) {

            if (empty($row) || !json_validate($row)) {
                continue;
            }

            ['bin' => $bin, 'amount' => $amount, 'currency' => $currency] = json_decode($row, true);

            $rate = $this->exchangeRates->getByCurrency($currency);
            if ($currency !== 'EUR' || $rate > 0) {
                $amount = bcdiv($amount, $rate, 2);
            }

            $isEu = $this->countryResolver->isEu($bin);
            $result[] = [
                'bin' => $bin,
                'amount' => $amount,
                'currency' => $currency,
                'commission' => bcmul($amount, $isEu ? 0.01 : 0.02, 2),
            ];
        }

        return $result;
    }
}