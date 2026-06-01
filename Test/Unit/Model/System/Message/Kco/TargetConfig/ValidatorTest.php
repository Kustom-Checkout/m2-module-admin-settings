<?php

/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Message\Kco\TargetConfig;

use Klarna\AdminSettings\Model\System\Message\Kco\TargetConfig\Validator;
use Klarna\Base\Test\Unit\Mock\ScopeMocker;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use Magento\Store\Model\Store;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Message\Kco\TargetConfig\Validator
 */
class ValidatorTest extends TestCase
{
    /**
     * @var Store|MockObject
     */
    private $storeMock;
    /**
     * @var Validator
     */
    private $model;
    /**
     * @var MockObject[]
     */
    private $dependencyMocks;

    /**
     * @covers ::getStoresWithoutEnabledCustomerGroups
     * @covers ::isAnyCustomerGroupEnabled
     */
    public function testGetStoresWithoutEnabledCustomerGroups(): void
    {
        $this->dependencyMocks['storeManager']->method('getStores')->willReturn([$this->storeMock]);
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('0,1,2,3');

        $this->dependencyMocks['group']->method('getAllOptions')->with(false)->willReturn([
            ['value' => -1],
            ['value' => 0],
            ['value' => 1],
            ['value' => 2],
            ['value' => 3],
        ]);

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWithoutEnabledCustomerGroups());
    }

    /**
     * @covers ::getStoresWithoutEnabledCustomerGroups
     * @covers ::isAnyCustomerGroupEnabled
     */
    public function testGetStoresWithoutEnabledCustomerGroupsWithOneGroupEnabled(): void
    {
        $this->dependencyMocks['storeManager']->method('getStores')->willReturn([$this->storeMock]);
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('1,2,3');

        $this->dependencyMocks['group']->method('getAllOptions')->with(false)->willReturn([
            ['value' => -1],
            ['value' => 0],
            ['value' => 1],
            ['value' => 2],
            ['value' => 3],
        ]);

        $this->assertEquals([], $this->model->getStoresWithoutEnabledCustomerGroups());
    }

    /**
     * @covers ::getStoresWithoutEnabledCustomerGroups
     * @covers ::isAnyCustomerGroupEnabled
     */
    public function testGetStoresWithoutEnabledCustomerGroupsWhereNoDisabledGroups(): void
    {
        $this->dependencyMocks['storeManager']->method('getStores')->willReturn([$this->storeMock]);
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('');

        $this->assertEquals([], $this->model->getStoresWithoutEnabledCustomerGroups());
    }

    /**
     * @covers ::getStoresWithoutEnabledShippingCountries
     * @covers ::isAnyShippingCountryEnabled
     */
    public function testGetStoresWithoutEnabledShippingCountries(): void
    {
        $this->dependencyMocks['storeManager']->method('getStores')->willReturn([$this->storeMock]);
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('');

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWithoutEnabledShippingCountries());
    }

    protected function setUp(): void
    {
        $objectFactory = new TestObjectFactory('');
        $presets = new ScopeMocker('');

        $this->storeMock = $presets->createStoreMock();
        $this->model = $objectFactory->create(Validator::class);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
    }
}
