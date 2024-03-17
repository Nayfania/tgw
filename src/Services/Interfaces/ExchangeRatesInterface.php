<?php

namespace App\Services\Interfaces;

interface ExchangeRatesInterface
{
    public function getByCurrency(string $code);
}