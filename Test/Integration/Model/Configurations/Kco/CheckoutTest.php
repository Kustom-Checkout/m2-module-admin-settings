<?php

/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

declare(strict_types=1);

namespace Klarna\AdminSettings\Test\Integration\Model\Configurations\Kco;

use Klarna\AdminSettings\Model\Configurations\Kco\Checkout;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    /**
     * @var ObjectManagerInterface|null
     */
    private ?ObjectManagerInterface $objectManager = null;

    /**
     * @var StoreInterface|null
     */
    private ?StoreInterface $store = null;

    /**
     * @var Checkout|null
     */
    private ?Checkout $model = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->store = $this->objectManager->create(StoreInterface::class);
        $this->model = $this->objectManager->create(Checkout::class);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoConfigFixture current_store checkout/klarna_kco/use_full_checkout 0
     * @magentoConfigFixture default/checkout/klarna_kco/use_full_checkout 0
     * @magentoConfigFixture test_store checkout/klarna_kco/use_full_checkout 1
     */
    public function testIsUseFullCheckoutShouldSuccessfullyReturnEnabledStoreSpecificConfigValue(): void
    {
        $this->store->setCode('test');

        $expectedResult = true;
        $result = $this->model->isUseFullCheckout($this->store);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoConfigFixture current_store checkout/klarna_kco/use_full_checkout 1
     * @magentoConfigFixture default/checkout/klarna_kco/use_full_checkout 1
     * @magentoConfigFixture test_store checkout/klarna_kco/use_full_checkout 0
     */
    public function testIsUseFullCheckoutShouldSuccessfullyReturnDisabledStoreSpecificConfigValue(): void
    {
        $this->store->setCode('test');

        $expectedResult = false;
        $result = $this->model->isUseFullCheckout($this->store);
        $this->assertEquals($expectedResult, $result);
    }
}
