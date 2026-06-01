<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Message\Kco\DesignConfig;

use Klarna\AdminSettings\Model\System\Message\Kco\DesignConfig\Notification;
use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Notification
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

    public function testGetTextReturnsEmptyForNoMessagesIfNoErrors(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereButtonColorInvalid')->willReturn([]);
        $this->dependencyMocks['validator']->method('getStoresWhereCheckboxColorInvalid')->willReturn([]);
        $this->dependencyMocks['validator']->method('getStoresWhereCheckboxCheckmarkColorInvalid')->willReturn([]);
        $this->dependencyMocks['validator']->method('getStoresWhereHeaderColorInvalid')->willReturn([]);
        $this->dependencyMocks['validator']->method('getStoresWhereLinkColorInvalid')->willReturn([]);

        $this->assertFalse($this->model->isDisplayed());
        $this->assertEmpty($this->model->getText());
    }

    public function testGetIdentity(): void
    {
        $this->assertEquals(
            'ae59611d75f0970a1032602bdce726fc4eec142de5a4b74eec03ce5a2a93a7d4',
            $this->model->getIdentity()
        );
    }

    public function testGetTextWhenButtonTextColorInvalid(): void
    {
        $message = 'Some message';

        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereButtonTextColorInvalid')->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidButtonTextColor')->willReturn($message);

        $this->assertTrue($this->model->isDisplayed());
        $this->assertEquals($message, $this->model->getText());
    }

    public function testGetTextWhenButtonColorInvalid(): void
    {
        $message = 'Some message';

        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereButtonColorInvalid')->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidButtonColor')->willReturn($message);

        $this->assertTrue($this->model->isDisplayed());
        $this->assertEquals($message, $this->model->getText());
    }

    public function testGetTextWhenCheckboxColorInvalid(): void
    {
        $message = 'Some message';

        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereCheckboxColorInvalid')->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidCheckboxColor')->willReturn($message);

        $this->assertTrue($this->model->isDisplayed());
        $this->assertEquals($message, $this->model->getText());
    }

    public function testGetTextWhenCheckboxCheckmarkColorInvalid(): void
    {
        $message = 'Some message';

        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereCheckboxCheckmarkColorInvalid')
            ->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidCheckboxCheckmarkColor')->willReturn($message);

        $this->assertTrue($this->model->isDisplayed());
        $this->assertEquals($message, $this->model->getText());
    }

    public function testGetTextWhenHeaderColorInvalid(): void
    {
        $message = 'Some message';

        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereHeaderColorInvalid')->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidHeaderColor')->willReturn($message);

        $this->assertTrue($this->model->isDisplayed());
        $this->assertEquals($message, $this->model->getText());
    }

    public function testGetTextWhenLinkColorInvalid(): void
    {
        $message = 'Some message';

        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereLinkColorInvalid')->willReturn(['default']);
        $this->dependencyMocks['message']->method('getMessageInvalidLinkColor')->willReturn($message);

        $this->assertTrue($this->model->isDisplayed());
        $this->assertEquals($message, $this->model->getText());
    }

    public function testGetSeverity(): void
    {
        $this->assertEquals(Notification::SEVERITY_CRITICAL, $this->model->getSeverity());
    }

    public function testIsDisplayedWhenButtonTextColorInvalid(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereButtonTextColorInvalid')->willReturn(['Default']);

        $this->assertTrue($this->model->isDisplayed());
    }

    public function testIsDisplayedWhenButtonColorInvalid(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereButtonColorInvalid')->willReturn(['Default']);

        $this->assertTrue($this->model->isDisplayed());
    }

    public function testIsDisplayedWhenCheckboxColorInvalid(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereCheckboxColorInvalid')->willReturn(['Default']);

        $this->assertTrue($this->model->isDisplayed());
    }

    public function testGetTextReturnsEmptyForNoMessagesIfCalledWithoutIsDisplay(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->assertEmpty($this->model->getText());
    }

    public function testIsDisplayedWhenCheckboxCheckmarkColorInvalid(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereCheckboxCheckmarkColorInvalid')
            ->willReturn(['Default']);

        $this->assertTrue($this->model->isDisplayed());
    }

    public function testIsDisplayedWhenHeaderColorInvalid(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereHeaderColorInvalid')->willReturn(['Default']);

        $this->assertTrue($this->model->isDisplayed());
    }

    public function testIsDisplayedWhenLinkColorInvalid(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(true);
        $this->dependencyMocks['validator']->method('getStoresWhereLinkColorInvalid')->willReturn(['Default']);

        $this->assertTrue($this->model->isDisplayed());
    }

    public function testIsDisplayedReturnsFalseWhenKlarnaIsDisabled(): void
    {
        $this->dependencyMocks['klarnaConfig']->method('isKlarnaEnabledInAnyStore')->willReturn(false);
        $this->dependencyMocks['validator']->expects($this->never())
            ->method('getStoresWhereButtonTextColorInvalid');

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
