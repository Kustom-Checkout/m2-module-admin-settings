<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Message\Kco\CheckoutConfig;

use Klarna\AdminSettings\Model\System\Message\Kco\CheckoutConfig\Notification;
use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Message\Kco\CheckoutConfig\Notification
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
    public function testGetTextWhenInvalidTitle(): void
    {
        $message = 'Some message';

        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereTitleIncorrect')->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidTitle')->willReturn($message);

        $this->assertTrue($this->model->isDisplayed());
        $this->assertEquals($message, $this->model->getText());
    }

    /**
     * @covers ::getText()
     */
    public function testGetTextWhenInvalidPhone(): void
    {
        $message = 'Some message';

        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWherePhoneIncorrect')->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidPhone')->willReturn($message);

        $this->assertTrue($this->model->isDisplayed());
        $this->assertEquals($message, $this->model->getText());
    }

    /**
     * @covers ::getText()
     */
    public function testGetTextWhenInvalidDateOfBirth(): void
    {
        $message = 'Some message';

        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereDateOfBirthIncorrect')->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidDateOfBirth')->willReturn($message);

        $this->assertTrue($this->model->isDisplayed());
        $this->assertEquals($message, $this->model->getText());
    }

    /**
     * @covers ::getText()
     */
    public function testGetTextWhenEmptyTermsUrl(): void
    {
        $message = 'Some message';

        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereTermsUrlEmpty')->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidTermsUrl')->willReturn($message);

        $this->assertTrue($this->model->isDisplayed());
        $this->assertEquals($message, $this->model->getText());
    }

    /**
     * @covers ::isDisplayed()
     */
    public function testIsDisplayedWhenInvalidPhone(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWherePhoneIncorrect')->willReturn(['Default']);

        $this->assertTrue($this->model->isDisplayed());
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
    public function testIsDisplayedWhenInvalidTitle(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereTitleIncorrect')->willReturn(['Default']);

        $this->assertTrue($this->model->isDisplayed());
    }

    /**
     * @covers ::isDisplayed()
     */
    public function testIsDisplayedWhenInvalidDateOfBirth(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereDateOfBirthIncorrect')->willReturn(['Default']);

        $this->assertTrue($this->model->isDisplayed());
    }

    /**
     * @covers ::isDisplayed()
     */
    public function testIsDisplayedWhenTermsUrlEmpty(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereTermsUrlEmpty')->willReturn(['Default']);

        $this->assertTrue($this->model->isDisplayed());
    }

    /**
     * @covers ::isDisplayed()
     */
    public function testIsDisplayedReturnsFalseWhenKlarnaIsDisabled(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(false);
        $this->dependencyMocks['validator']->expects($this->never())->method('getStoresWhereDateOfBirthIncorrect');

        $this->assertFalse($this->model->isDisplayed());
    }

    /**
     * @covers ::getIdentity()
     */
    public function testGetIdentity(): void
    {
        $this->assertEquals(
            '0d840fef0e7480de8d48a719b834396c61ca02130337f648d572ea857f761ad1',
            $this->model->getIdentity()
        );
    }

    protected function setUp(): void
    {
        $mockFactory = new MockFactory($this);
        $objectFactory = new TestObjectFactory('');
        $this->model = $objectFactory->create(Notification::class);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
    }
}
