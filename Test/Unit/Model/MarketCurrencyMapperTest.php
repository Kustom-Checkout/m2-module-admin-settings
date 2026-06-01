<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */
declare(strict_types=1);

namespace Klarna\AdminSettings\Test\Unit\Model;

use Klarna\AdminSettings\Model\MarketCurrencyMapper;
use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\MarketCurrencyMapper
 */
class MarketCurrencyMapperTest extends TestCase
{
    /**
     * @var MarketCurrencyMapper
     */
    private MarketCurrencyMapper $marketCurrencyMapper;

    public function testGetCurrencyByMarketInputEuReturningEur(): void
    {
        static::assertEquals('EUR', $this->marketCurrencyMapper->getCurrencyByMarket('eu'));
    }

    public function testGetCurrencyByMarketInputUsReturningUsd(): void
    {
        static::assertEquals('USD', $this->marketCurrencyMapper->getCurrencyByMarket('us'));
    }

    public function testGetCurrencyByMarketInputMxReturningMxn(): void
    {
        static::assertEquals('MXN', $this->marketCurrencyMapper->getCurrencyByMarket('mx'));
    }

    public function testGetCurrencyByMarketInputCaReturningCad(): void
    {
        static::assertEquals('CAD', $this->marketCurrencyMapper->getCurrencyByMarket('ca'));
    }

    public function testGetCurrencyByMarketInputAuReturningAud(): void
    {
        static::assertEquals('AUD', $this->marketCurrencyMapper->getCurrencyByMarket('au'));
    }

    public function testGetCurrencyByMarketInputNzReturningNzd(): void
    {
        static::assertEquals('NZD', $this->marketCurrencyMapper->getCurrencyByMarket('nz'));
    }

    public function testGetCurrencyByMarketInputInvalidMarketReturningEmptyResult(): void
    {
        static::assertEquals('', $this->marketCurrencyMapper->getCurrencyByMarket('invalid_market'));
    }

    protected function setUp(): void
    {
        $mockFactory = new MockFactory($this);
        $objectFactory = new TestObjectFactory('');

        $this->marketCurrencyMapper = $objectFactory->create(MarketCurrencyMapper::class);
    }
}
