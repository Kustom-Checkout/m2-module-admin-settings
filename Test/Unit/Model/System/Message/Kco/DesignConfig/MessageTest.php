<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Message\Kco\DesignConfig;

use Klarna\Base\Test\Unit\TestsContains;
use Klarna\AdminSettings\Model\System\Message\Kco\DesignConfig\Message;
use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use Klarna\Kco\Test\Unit\TestsHtml;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Message\Kco\DesignConfig\Message
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
     * @var Message
     */
    private $model;
    /**
     * @var MockObject[]
     */
    private $dependencyMocks;

    /**
     * @covers ::getMessageInvalidLinkColor
     * @covers ::getPrefixMessage
     * @covers ::getCoreMessage
     * @covers ::getSuffixMessage
     */
    public function testGetMessageInvalidLinkColor(): void
    {
        $actualMessage = $this->model->getMessageInvalidLinkColor(['Default']);
        $this->assertBasicTextExists($actualMessage);
        $this->assertStringContainsString('link color', $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidLinkColor
     */
    public function testGetMessageInvalidLinkColorValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidLinkColor(['Default']);
        $this->assertTrue($this->validateHtml($actualMessage), 'HTML is invalid');
    }

    /**
     * @covers ::getMessageInvalidButtonColor
     * @covers ::getPrefixMessage
     * @covers ::getCoreMessage
     * @covers ::getSuffixMessage
     */
    public function testGetMessageInvalidButtonColor(): void
    {
        $actualMessage = $this->model->getMessageInvalidButtonColor(['Default']);
        $this->assertBasicTextExists($actualMessage);
        $this->assertStringContainsString('button color', $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidButtonColor
     */
    public function testGetMessageInvalidButtonColorValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidButtonColor(['Default']);
        $this->assertTrue($this->validateHtml($actualMessage), 'HTML is invalid');
    }

    /**
     * @covers ::getMessageInvalidCheckboxCheckmarkColor
     * @covers ::getPrefixMessage
     * @covers ::getCoreMessage
     * @covers ::getSuffixMessage
     */
    public function testGetMessageInvalidCheckboxCheckmarkColor(): void
    {
        $actualMessage = $this->model->getMessageInvalidCheckboxCheckmarkColor(['Default']);
        $this->assertBasicTextExists($actualMessage);
        $this->assertStringContainsString('checkbox checkmark color', $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidCheckboxCheckmarkColor
     */
    public function testGetMessageInvalidCheckboxCheckmarkColorValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidCheckboxCheckmarkColor(['Default']);
        $this->assertTrue($this->validateHtml($actualMessage), 'HTML is invalid');
    }

    /**
     * @covers ::getMessageInvalidCheckboxColor
     * @covers ::getPrefixMessage
     * @covers ::getCoreMessage
     * @covers ::getSuffixMessage
     */
    public function testGetMessageInvalidCheckboxColor(): void
    {
        $actualMessage = $this->model->getMessageInvalidCheckboxColor(['Default']);
        $this->assertBasicTextExists($actualMessage);
        $this->assertStringContainsString('checkbox', $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidCheckboxColor
     */
    public function testGetMessageInvalidCheckboxColorValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidCheckboxColor(['Default']);
        $this->assertTrue($this->validateHtml($actualMessage), 'HTML is invalid');
    }

    /**
     * @covers ::getMessageInvalidButtonTextColor
     * @covers ::getPrefixMessage
     * @covers ::getCoreMessage
     * @covers ::getSuffixMessage
     */
    public function testGetMessageInvalidButtonTextColor(): void
    {
        $actualMessage = $this->model->getMessageInvalidButtonTextColor(['Default']);
        $this->assertBasicTextExists($actualMessage);
        $this->assertStringContainsString('button text', $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidButtonTextColor
     */
    public function testGetMessageInvalidButtonTextColorValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidButtonTextColor(['Default']);
        $this->assertTrue($this->validateHtml($actualMessage), 'HTML is invalid');
    }

    /**
     * @covers ::getMessageInvalidHeaderColor
     * @covers ::getPrefixMessage
     * @covers ::getCoreMessage
     * @covers ::getSuffixMessage
     */
    public function testGetMessageInvalidHeaderColor(): void
    {
        $actualMessage = $this->model->getMessageInvalidHeaderColor(['Default']);
        $this->assertBasicTextExists($actualMessage);
        $this->assertStringContainsString('header color', $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidHeaderColor
     */
    public function testGetMessageInvalidHeaderColorValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidHeaderColor(['Default']);
        $this->assertTrue($this->validateHtml($actualMessage), 'HTML is invalid');
    }

    /**
     * Handles assertions for text that should be returned on all methods
     *
     * @param string $actualMessage
     */
    private function assertBasicTextExists($actualMessage): void
    {
        $this->assertStringContainsString(__('Klarna Checkout design warning:')->__toString(), $actualMessage);
        $this->assertStringContainsString(__('Store(s) affected: ') . 'Default', $actualMessage);
        $this->assertStringContainsString(self::CHECKOUT_CONFIG_URL, $actualMessage);
    }

    protected function setUp(): void
    {
        $mockFactory = new MockFactory($this);
        $objectFactory = new TestObjectFactory('');

        // Main class being tested
        $this->model = $objectFactory->create(Message::class);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
        $this->dependencyMocks['url']->method('getUrl')->willReturn(self::CHECKOUT_CONFIG_URL);
    }
}
