<?php

namespace App\Services\Mocks;

use App\Services\Interfaces\CountryResolverInterface;

class CountryResolverMock implements CountryResolverInterface
{
    public function byBIN(string $bin): string
    {
        return '';
    }

    public function isEu(string $bin): bool
    {
        return true;
    }
}