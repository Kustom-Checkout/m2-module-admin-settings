<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Message\Kco\CheckoutConfig;

use Klarna\Base\Test\Unit\TestsContains;
use Klarna\AdminSettings\Model\System\Message\Kco\CheckoutConfig\Message;
use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use Klarna\Kco\Test\Unit\TestsHtml;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Message\Kco\CheckoutConfig\Message
 */
class MessageTest extends TestCase
{
    use TestsHtml, TestsContains;

    /**
     * Used in mock and to verify tests are returning full output
     *
     * @var string
     */
    private const CHECKOUT_CONFIG_URL = 'some-url';
    /**
     * Used in mock and to verify tests are returning full output
     *
     * @var string
     */
    private const CUSTOMER_CONFIG_URL = 'some-other-url';
    /**
     * @var Message
     */
    private $model;
    /**
     * @var MockObject[]
     */
    private $dependencyMocks;

    /**
     * @covers ::getMessageInvalidTitle
     */
    public function testGetMessageInvalidTitle(): void
    {
        $message = __(
            'The title value from the Kustom Checkout and customer settings are incorrectly configured. ' .
            'Either they should both be required or you can leave the setting as optional under customer ' .
            'settings. However, if the setting is “required” under customer settings then it must be set to ' .
            '“required” under Kustom Checkout as well.'
        );
        $this->dependencyMocks['url']->method('getUrl')
            ->willReturnCallback(fn($url) =>
                match($url) {
                    'adminhtml/system_config/edit/section/checkout' => self::CHECKOUT_CONFIG_URL,
                    'adminhtml/system_config/edit/section/customer' => self::CUSTOMER_CONFIG_URL
                }
            );

        $actualMessage = $this->model->getMessageInvalidTitle(['Default']);
        self::assertStringContainsString(__('Kustom Checkout title mandatory warning:')->__toString(), $actualMessage);
        self::assertStringContainsString(__('Store(s) affected: ') . 'Default', $actualMessage);
        self::assertStringContainsString(self::CHECKOUT_CONFIG_URL, $actualMessage);
        self::assertStringContainsString(self::CUSTOMER_CONFIG_URL, $actualMessage);
        self::assertStringContainsString($message->__toString(), $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidTitle
     */
    public function testGetMessageInvalidTitleReturnsValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidTitle(['Default']);
        $this->assertTrue($this->validateHtml($actualMessage), 'HTML is invalid');
    }

    /**
     * @covers ::getMessageInvalidPhone
     */
    public function testGetMessageInvalidPhone(): void
    {
        $message = __(
            'The phone value from the Kustom Checkout and customer settings are incorrectly configured. ' .
            'Either they should both be required or you can leave the setting as optional under customer ' .
            'settings. However, if the setting is “required” under customer settings then it must be set to ' .
            '“required” under Kustom Checkout as well.'
        );
        $this->dependencyMocks['url']->method('getUrl')
            ->willReturnCallback(fn($url) =>
                match($url) {
                    'adminhtml/system_config/edit/section/checkout' => self::CHECKOUT_CONFIG_URL,
                    'adminhtml/system_config/edit/section/customer' => self::CUSTOMER_CONFIG_URL
                }
            );

        $actualMessage = $this->model->getMessageInvalidPhone(['Default']);
        self::assertStringContainsString(__('Kustom Checkout phone mandatory warning:')->__toString(), $actualMessage);
        self::assertStringContainsString(__('Store(s) affected: ') . 'Default', $actualMessage);
        self::assertStringContainsString(self::CHECKOUT_CONFIG_URL, $actualMessage);
        self::assertStringContainsString(self::CUSTOMER_CONFIG_URL, $actualMessage);
        self::assertStringContainsString($message->__toString(), $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidPhone
     */
    public function testGetMessageInvalidPhoneReturnsValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidPhone(['Default']);
        $this->assertTrue($this->validateHtml($actualMessage), 'HTML is invalid');
    }

    /**
     * @covers ::getMessageInvalidDateOfBirth
     */
    public function testGetMessageInvalidDateOfBirth(): void
    {
        $message = __(
            'The date of birth value from the Kustom Checkout and customer settings are incorrectly configured. ' .
            'Either they should both be required or you can leave the setting as optional under customer ' .
            'settings. However, if the setting is “required” under customer settings then it must be set to ' .
            '“required” under Kustom Checkout as well.'
        );
        $this->dependencyMocks['url']->method('getUrl')
            ->willReturnCallback(fn($url) =>
                match($url) {
                    'adminhtml/system_config/edit/section/checkout' => self::CHECKOUT_CONFIG_URL,
                    'adminhtml/system_config/edit/section/customer' => self::CUSTOMER_CONFIG_URL
                }
            );

        $actualMessage = $this->model->getMessageInvalidDateOfBirth(['Default']);
        self::assertStringContainsString(
            __('Kustom Checkout date of birth mandatory warning:')->__toString(),
            $actualMessage
        );
        self::assertStringContainsString(__('Store(s) affected: ') . 'Default', $actualMessage);
        self::assertStringContainsString(self::CHECKOUT_CONFIG_URL, $actualMessage);
        self::assertStringContainsString(self::CUSTOMER_CONFIG_URL, $actualMessage);
        self::assertStringContainsString($message->__toString(), $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidDateOfBirth
     */
    public function testGetMessageInvalidDateOfBirthReturnsValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidDateOfBirth(['Default']);
        $this->assertTrue($this->validateHtml($actualMessage), 'HTML is invalid');
    }

    /**
     * @covers ::getMessageInvalidTermsUrl
     */
    public function testGetMessageInvalidTermsUrl(): void
    {
        $message = __(
            'No url for the terms and conditions is configured. ' .
            'Please setup a url.'
        );
        $this->dependencyMocks['url']->method('getUrl')->willReturn(self::CHECKOUT_CONFIG_URL);

        $actualMessage = $this->model->getMessageInvalidTermsUrl(['Default']);
        self::assertStringContainsString(
            __('Kustom Checkout terms and conditions warning:')->__toString(),
            $actualMessage
        );
        self::assertStringContainsString(__('Store(s) affected: ') . 'Default', $actualMessage);
        self::assertStringContainsString(self::CHECKOUT_CONFIG_URL, $actualMessage);
        self::assertStringContainsString($message->__toString(), $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidTermsUrl
     */
    public function testGetMessageInvalidTermsUrlReturnsValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidTermsUrl(['Default']);
        $this->assertTrue($this->validateHtml($actualMessage), 'HTML is invalid');
    }

    protected function setUp(): void
    {
        $mockFactory = new MockFactory($this);
        $objectFactory = new TestObjectFactory('');

        // Main class being tested
        $this->model = $objectFactory->create(Message::class);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
    }
}
