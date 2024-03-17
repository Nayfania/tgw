<?php

namespace App\Tests\Unit;

use App\Services\CommissionManager;
use App\Tests\Support\UnitTester;

class CommissionManagerTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    public function testCalculateDataIsEmpty()
    {
        /** @var CommissionManager $commissionManager */
        $commissionManager = $this->tester->grabService(CommissionManager::class);

        self::assertEquals([], $commissionManager->calculate([]));
    }

    public function testCalculateIncorrectJSON()
    {
        /** @var CommissionManager $commissionManager */
        $commissionManager = $this->tester->grabService(CommissionManager::class);

        self::assertEquals([], $commissionManager->calculate(['sdfsdf']));
    }

    public function testCalculateOneRow()
    {
        /** @var CommissionManager $commissionManager */
        $commissionManager = $this->tester->grabService(CommissionManager::class);

        self::assertEquals([[
            'bin' => '45717360',
            'amount' => '100.00',
            'currency' => 'EUR',
            'commission' => '1.00',
        ]], $commissionManager->calculate(['{"bin":"45717360","amount":"100.00","currency":"EUR"}']));
    }
}