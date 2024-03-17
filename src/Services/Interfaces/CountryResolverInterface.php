<?php

namespace App\Services\Interfaces;

interface CountryResolverInterface
{
    public function byBIN(string $bin): string;

    public function isEu(string $bin): bool;
}