<?php

namespace App\Services\Mocks;

use App\Services\Interfaces\ExchangeRatesInterface;

class ExchangeRatesMock implements ExchangeRatesInterface
{
    public function getByCurrency(string $code)
    {
        return 1;
    }
}