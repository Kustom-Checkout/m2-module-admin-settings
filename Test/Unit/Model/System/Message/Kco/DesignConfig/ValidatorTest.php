<?php

/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Message\Kco\DesignConfig;

use Klarna\AdminSettings\Model\System\Message\Kco\DesignConfig\Validator;
use Klarna\Base\Test\Unit\Mock\ScopeMocker;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use Magento\Store\Model\Store;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Message\Kco\DesignConfig\Validator
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
     * @covers ::getStoresWhereLinkColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereLinkColorInvalid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('bad-value');

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereLinkColorInvalid());
    }

    /**
     * @covers ::getStoresWhereHeaderColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereHeaderColorInvalid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('bad-value');

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereHeaderColorInvalid());
    }

    /**
     * @covers ::getStoresWhereCheckboxCheckmarkColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereCheckboxCheckmarkColorInvalid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('bad-value');

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereCheckboxCheckmarkColorInvalid());
    }

    /**
     * @covers ::getStoresWhereButtonColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereButtonColorInvalid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('bad-value');

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereButtonColorInvalid());
    }

    /**
     * @covers ::getStoresWhereCheckboxColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereCheckboxColorInvalid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('bad-value');

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereCheckboxColorInvalid());
    }

    /**
     * @covers ::getStoresWhereButtonTextColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereButtonTextColorInvalid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('bad-value');

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereButtonTextColorInvalid());
    }

    /**
     * @covers ::getStoresWhereLinkColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereLinkColorEmpty(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('');

        $this->assertEquals([], $this->model->getStoresWhereLinkColorInvalid());
    }

    /**
     * @covers ::getStoresWhereHeaderColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereHeaderColorEmpty(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('');

        $this->assertEquals([], $this->model->getStoresWhereHeaderColorInvalid());
    }

    /**
     * @covers ::getStoresWhereCheckboxCheckmarkColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereCheckboxCheckmarkColorEmpty(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('');

        $this->assertEquals([], $this->model->getStoresWhereCheckboxCheckmarkColorInvalid());
    }

    /**
     * @covers ::getStoresWhereButtonColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereButtonColorEmpty(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('');

        $this->assertEquals([], $this->model->getStoresWhereButtonColorInvalid());
    }

    /**
     * @covers ::getStoresWhereCheckboxColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereCheckboxColorEmpty(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('');

        $this->assertEquals([], $this->model->getStoresWhereCheckboxColorInvalid());
    }

    /**
     * @covers ::getStoresWhereButtonTextColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereButtonTextColorEmpty(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('');

        $this->assertEquals([], $this->model->getStoresWhereButtonTextColorInvalid());
    }

    /**
     * @covers ::getStoresWhereLinkColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereLinkColorValid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('#000000');

        $this->assertEquals([], $this->model->getStoresWhereLinkColorInvalid());
    }

    /**
     * @covers ::getStoresWhereHeaderColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereHeaderColorValid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('#000000');

        $this->assertEquals([], $this->model->getStoresWhereHeaderColorInvalid());
    }

    /**
     * @covers ::getStoresWhereCheckboxCheckmarkColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereCheckboxCheckmarkColorValid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('#000000');

        $this->assertEquals([], $this->model->getStoresWhereCheckboxCheckmarkColorInvalid());
    }

    /**
     * @covers ::getStoresWhereButtonColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereButtonColorValid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('#000000');

        $this->assertEquals([], $this->model->getStoresWhereButtonColorInvalid());
    }

    /**
     * @covers ::getStoresWhereCheckboxColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereCheckboxColorValid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('#000000');

        $this->assertEquals([], $this->model->getStoresWhereCheckboxColorInvalid());
    }

    /**
     * @covers ::getStoresWhereButtonTextColorInvalid()
     * @covers ::isValidCssHexColorCode
     */
    public function testGetStoresWhereButtonTextColorValid(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('#000000');

        $this->assertEquals([], $this->model->getStoresWhereButtonTextColorInvalid());
    }

    protected function setUp(): void
    {
        $objectFactory = new TestObjectFactory('');
        $presets = new ScopeMocker('');

        $this->storeMock = $presets->createStoreMock();
        $this->model = $objectFactory->create(Validator::class);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
        $this->dependencyMocks['storeManager']->method('getStores')->willReturn([$this->storeMock]);
    }
}
