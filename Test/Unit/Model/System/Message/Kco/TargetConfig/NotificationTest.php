<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Message\Kco\TargetConfig;

use Klarna\AdminSettings\Model\System\Message\Kco\TargetConfig\Notification;
use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Message\Kco\TargetConfig\Notification
 */
class NotificationTest extends TestCase
{
    /**
     * @var Notification
     */
    private $model;
    /**
     * @var MockObject[]
     */
    private $dependencyMocks;

    /**
     * @covers ::getText()
     */
    public function testGetTextReturnsEmptyForNoMessagesIfNoErrors(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWithoutEnabledShippingCountries')
            ->willReturn([]);
        $this->assertFalse($this->model->isDisplayed());
        $this->assertEmpty($this->model->getText());
    }

    /**
     * @covers ::getText()
     */
    public function testGetTextReturnsMessageForInvalidShippingCountries(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWithoutEnabledShippingCountries')
            ->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidShippingCountries')
            ->willReturn('invalid shipping countries');

        $this->assertTrue($this->model->isDisplayed());
        $this->assertNotEmpty($this->model->getText());
    }

    /**
     * @covers ::getText()
     */
    public function testGetTextReturnsMessageForInvalidCustomerGroups(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWithoutEnabledCustomerGroups')
            ->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidCustomerGroups')
            ->willReturn('invalid customer groups');

        $this->assertTrue($this->model->isDisplayed());
        $this->assertNotEmpty($this->model->getText());
    }

    /**
     * @covers ::getIdentity()
     */
    public function testGetIdentity(): void
    {
        $this->assertEquals(
            'f9ffbcde1030a905de5bc25d8098248e8b4f21a648db207322f16108edb7c8d3',
            $this->model->getIdentity()
        );
    }

    /**
     * @covers ::getSeverity()
     */
    public function testGetSeverity(): void
    {
        $this->assertEquals(Notification::SEVERITY_CRITICAL, $this->model->getSeverity());
    }

    /**
     * @covers ::isDisplayed()
     */
    public function testIsDisplayedWhenThereAreStoresWithoutEnabledShippingCountries(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWithoutEnabledShippingCountries')
            ->willReturn(['default']);
        $this->assertTrue($this->model->isDisplayed());
    }

    /**
     * @covers ::isDisplayed()
     */
    public function testIsDisplayedWhenThereAreStoresWithoutEnabledCustomerGroups(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWithoutEnabledCustomerGroups')->willReturn(['default']);
        $this->assertTrue($this->model->isDisplayed());
    }

    /**
     * @covers ::getText()
     */
    public function testGetTextReturnsEmptyForNoMessagesIfCalledWithoutIsDisplay(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->assertEmpty($this->model->getText());
    }

    /**
     * @covers ::isDisplayed()
     */
    public function testIsDisplayedReturnsFalseWhenKlarnaIsDisabled(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(false);
        $this->dependencyMocks['validator']->expects($this->never())
            ->method('getStoresWithoutEnabledShippingCountries');
        $this->assertFalse($this->model->isDisplayed());
    }

    protected function setUp(): void
    {
        $mockFactory = new MockFactory($this);
        $objectFactory = new TestObjectFactory('');
        $this->model = $objectFactory->create(Notification::class);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
    }
}
