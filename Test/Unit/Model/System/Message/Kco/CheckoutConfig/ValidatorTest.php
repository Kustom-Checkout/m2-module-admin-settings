<?php

/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Message\Kco\CheckoutConfig;

use Klarna\AdminSettings\Model\System\Message\Kco\CheckoutConfig\Validator;
use Klarna\Base\Test\Unit\Mock\ScopeMocker;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;
use Magento\Store\Model\Store;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Message\Kco\CheckoutConfig\Validator
 * @testdox The Validator class
 */
class ValidatorTest extends TestCase
{
    /**
     * @var AbstractAttribute|MockObject
     */
    private $attributeMock;
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
     * @covers ::getStoresWhereTitleIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns a store when running Enterprise version and the title is incorrectly configured so that Magento
     *          requires it and Klarna does not
     */
    public function testGetStoresWhereTitleIncorrectEnterpriseMagentoRequiredKlarnaNot(): void
    {
        $this->attributeMock->method('getIsRequired')->willReturn('req');
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(false);

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereTitleIncorrect());
    }

    /**
     * @covers ::getStoresWhereTitleIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns a store when running Community version and the title is incorrectly configured so that Magento
     *          requires it and Klarna does not
     */
    public function testGetStoresWhereTitleIncorrectCommunityMagentoRequiredKlarnaNot(): void
    {
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(false);
        $this->dependencyMocks['info']->method('getMageEdition')->willReturn('Community');
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('1');

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereTitleIncorrect());
    }

    /**
     * @covers ::getStoresWhereTitleIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns an empty array when running Enterprise version and the title is correctly configured so that
     *          both Magento and Klarna require it
     */
    public function testGetStoresWhereTitleIncorrectEnterpriseMagentoRequiredKlarnaRequired(): void
    {
        $this->attributeMock->method('getIsRequired')->willReturn('req');
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(true);

        $this->assertEquals([], $this->model->getStoresWhereTitleIncorrect());
    }

    /**
     * @covers ::getStoresWhereTitleIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns an empty array when running Community version and the title is correctly configured so that
     *          both Magento and Klarna require it
     */
    public function testGetStoresWhereTitleIncorrectCommunityMagentoRequiredKlarnaRequired(): void
    {
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(true);
        $this->dependencyMocks['info']->method('getMageEdition')->willReturn('Community');
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('1');

        $this->assertEquals([], $this->model->getStoresWhereTitleIncorrect());
    }

    /**
     * @covers ::getStoresWhereTitleIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns an empty array when running Enterprise version and the title is correctly configured so that
     *          Magento does not require it, but Klarna does
     */
    public function testGetStoresWhereTitleIncorrectEnterpriseMagentoNotKlarnaRequired(): void
    {
        $this->attributeMock->method('getIsRequired')->willReturn('0');
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(true);

        $this->assertEquals([], $this->model->getStoresWhereTitleIncorrect());
    }

    /**
     * @covers ::getStoresWhereTitleIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns an empty array when running Community version and the title is correctly configured so that
     *          Magento does not require it, but Klarna does
     */
    public function testGetStoresWhereTitleIncorrectCommunityMagentoNotKlarnaRequired(): void
    {
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(true);
        $this->dependencyMocks['info']->method('getMageEdition')->willReturn('Community');
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('0');

        $this->assertEquals([], $this->model->getStoresWhereTitleIncorrect());
    }

    /**
     * @covers ::getStoresWherePhoneIncorrect()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns a store when phone is incorrectly configured so Magento requires it but Klarna does not
     */
    public function testGetStoresWherePhoneIncorrectMagentoRequiredKlarnaNot(): void
    {
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(false);
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('1');

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWherePhoneIncorrect());
    }

    /**
     * @covers ::getStoresWherePhoneIncorrect()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns an empty array when phone is correctly configured so both Magento and Klarna requires it
     */
    public function testGetStoresWherePhoneIncorrectMagentoRequiredKlarnaRequired(): void
    {
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(true);
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('1');

        $this->assertEquals([], $this->model->getStoresWherePhoneIncorrect());
    }

    /**
     * @covers ::getStoresWherePhoneIncorrect()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns an empty array when phone is correctly configured so Magento does not require it but Klarna does
     */
    public function testGetStoresWherePhoneIncorrectMagentoNotKlarnaRequired(): void
    {
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(true);
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('0');

        $this->assertEquals([], $this->model->getStoresWherePhoneIncorrect());
    }

    /**
     * @covers ::getStoresWhereDateOfBirthIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns a store when running Enterprise version and date of birth is incorrectly configured so Magento
     *          requires it but Klarna does not
     */
    public function testGetStoresWhereDateOfBirthIncorrectEnterpriseMagentoRequiredKlarnaNot(): void
    {
        $this->attributeMock->method('getIsRequired')->willReturn('req');
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(false);

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereDateOfBirthIncorrect());
    }

    /**
     * @covers ::getStoresWhereDateOfBirthIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns a store when running Community version and date of birth is incorrectly configured so Magento
     *          requires it but Klarna does not
     */
    public function testGetStoresWhereDateOfBirthIncorrectCommunityMagentoRequiredKlarnaNot(): void
    {
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(false);
        $this->dependencyMocks['info']->method('getMageEdition')->willReturn('Community');
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('1');

        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereDateOfBirthIncorrect());
    }

    /**
     * @covers ::getStoresWhereDateOfBirthIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns an empty array when running Enterprise version and date of birth is correctly configured so both
     *          Magento and Klarna requires it
     */
    public function testGetStoresWhereDateOfBirthIncorrectEnterpriseMagentoRequiredKlarnaRequired(): void
    {
        $this->attributeMock->method('getIsRequired')->willReturn('req');
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(true);

        $this->assertEquals([], $this->model->getStoresWhereDateOfBirthIncorrect());
    }

    /**
     * @covers ::getStoresWhereDateOfBirthIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns an empty array when running Community version and date of birth is correctly configured so both
     *          Magento and Klarna requires it
     */
    public function testGetStoresWhereDateOfBirthIncorrectCommunityMagentoRequiredKlarnaRequired(): void
    {
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(true);
        $this->dependencyMocks['info']->method('getMageEdition')->willReturn('Community');
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('1');

        $this->assertEquals([], $this->model->getStoresWhereDateOfBirthIncorrect());
    }

    /**
     * @covers ::getStoresWhereDateOfBirthIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns an empty array when running Enterprise version and date of birth is correctly configured so
     *          Magento does not require it but Klarna does
     */
    public function testGetStoresWhereDateOfBirthIncorrectEnterpriseMagentoNotKlarnaRequired(): void
    {
        $this->attributeMock->method('getIsRequired')->willReturn('0');
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(true);

        $this->assertEquals([], $this->model->getStoresWhereDateOfBirthIncorrect());
    }

    /**
     * @covers ::getStoresWhereDateOfBirthIncorrect()
     * @covers ::isCustomerEavValueRequired()
     * @covers ::getScopeConfigValue()
     * @covers ::settingsValid()
     * @testdox returns an empty array when running Community version and date of birth is correctly configured so
     *          Magento does not require it but Klarna does
     */
    public function testGetStoresWhereDateOfBirthIncorrectCommunityMagentoNotKlarnaRequired(): void
    {
        $this->dependencyMocks['providerConfig']->method('isCheckoutConfigFlag')->willReturn(true);
        $this->dependencyMocks['info']->method('getMageEdition')->willReturn('Community');
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('0');

        $this->assertEquals([], $this->model->getStoresWhereDateOfBirthIncorrect());
    }

    /**
     * @covers ::getStoresWhereTermsUrlEmpty()
     * @covers ::getScopeConfigValue()
     * @covers ::isTermsUrlEmpty()
     * @covers ::settingsValid()
     */
    public function testGetStoresWhereTermsUrlEmpty(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('');
        $this->assertEquals(['Default(Default)'], $this->model->getStoresWhereTermsUrlEmpty());
    }

    /**
     * @covers ::getStoresWhereTermsUrlEmpty()
     * @covers ::getScopeConfigValue()
     * @covers ::isTermsUrlEmpty()
     * @covers ::settingsValid()
     */
    public function testGetStoresWhereTermsUrlNotEmpty(): void
    {
        $this->dependencyMocks['scopeConfig']->method('getValue')->willReturn('terms');
        $this->assertEquals([], $this->model->getStoresWhereTermsUrlEmpty());
    }

    protected function setUp(): void
    {
        $objectFactory = new TestObjectFactory('');
        $presets = new ScopeMocker('');

        $this->storeMock = $presets->createStoreMock();
        $this->model = $objectFactory->create(Validator::class);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
        $this->attributeMock = $this->createMock(AbstractAttribute::class);
        $this->dependencyMocks['config']->method('getAttribute')->willReturn($this->attributeMock);
        $this->dependencyMocks['storeManager']->method('getStores')->willReturn([$this->storeMock]);
    }
}
