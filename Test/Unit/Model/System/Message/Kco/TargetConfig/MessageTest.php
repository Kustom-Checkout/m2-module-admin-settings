<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Message\Kco\TargetConfig;

use Klarna\Base\Test\Unit\TestsContains;
use Klarna\AdminSettings\Model\System\Message\Kco\TargetConfig\Message;
use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use Klarna\Kco\Test\Unit\TestsHtml;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Message\Kco\TargetConfig\Message
 */
class MessageTest extends TestCase
{
    use TestsHtml, TestsContains;

    /**
     * Used in mock and to verify tests are returning full output
     *
     * @var string
     */
    private const PAYMENT_CONFIG_URL = 'some-url';
    /**
     * @var Message
     */
    private $model;
    /**
     * @var MockObject[]
     */
    private $dependencyMocks;

    /**
     * @covers ::getMessageInvalidShippingCountries
     */
    public function testGetMessageInvalidShippingCountries(): void
    {
        $actualMessage = $this->model->getMessageInvalidShippingCountries(['default']);
        $this->assertStringContainsString(
            __('Klarna Checkout shipping country configuration warning:')->__toString(),
            $actualMessage
        );
        $this->assertStringContainsString(__('Store(s) affected: ') . 'default', $actualMessage);
        $this->assertStringContainsString(self::PAYMENT_CONFIG_URL, $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidShippingCountries
     */
    public function testGetMessageInvalidShippingCountriesReturnsValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidShippingCountries(['default']);
        $this->assertTrue($this->validateHtml($actualMessage));
    }

    /**
     * @covers ::getMessageInvalidCustomerGroups
     */
    public function testGetMessageInvalidCustomerGroups(): void
    {
        $actualMessage = $this->model->getMessageInvalidCustomerGroups(['default']);
        $this->assertStringContainsString(
            __('Klarna Checkout customer group configuration warning:')->__toString(),
            $actualMessage
        );
        $this->assertStringContainsString(__('Store(s) affected: ') . 'default', $actualMessage);
        $this->assertStringContainsString(self::PAYMENT_CONFIG_URL, $actualMessage);
    }

    /**
     * @covers ::getMessageInvalidCustomerGroups
     */
    public function testGetMessageInvalidCustomerGroupsReturnsValidHtml(): void
    {
        $actualMessage = $this->model->getMessageInvalidCustomerGroups(['default']);
        $this->assertTrue($this->validateHtml($actualMessage));
    }

    protected function setUp(): void
    {
        $mockFactory = new MockFactory($this);
        $objectFactory = new TestObjectFactory('');
        $this->model = $objectFactory->create(Message::class);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
        $this->dependencyMocks['url']->method('getUrl')->willReturn(self::PAYMENT_CONFIG_URL);
    }
}
