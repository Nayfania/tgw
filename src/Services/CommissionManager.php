<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class CommissionManager
{
    public function __construct(
        private readonly CountryResolver $countryResolver,
        private readonly ExchangeRates   $exchangeRates
    )
    {
    }

    public function calculate(UploadedFile $file): array
    {
        $content = $file->getContent();

        $result = [];
        foreach (explode("\n", $content) as $row) {

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