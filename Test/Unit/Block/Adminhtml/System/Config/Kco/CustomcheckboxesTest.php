<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Block\Adminhtml\System\Config\Kco;

use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use PHPUnit\Framework\TestCase;
use Klarna\AdminSettings\Block\Adminhtml\System\Config\Kco\Customcheckboxes;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Block\Adminhtml\System\Config\Kco\Customcheckboxes
 */
class CustomcheckboxesTest extends TestCase
{
    /**
     * @var Customcheckboxes
     */
    private $customcheckboxes;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject[]
     */
    private $dependencyMocks;
    /**
     * @var AbstractElement|\PHPUnit_Framework_MockObject_MockObject
     */
    private $abstractElement;

    /**
     * There will be 4 columns added.
     *
     * @covers ::_prepareToRender
     */
    public function testAddedColumns()
    {
        $this->customcheckboxes->_prepareToRender();
        static::assertCount(4, $this->customcheckboxes->getColumns());
    }

    /**
     * Use a invalid value for "columnname" so that the the first condition of the "if" will fail.
     *
     * @covers                   ::renderCellTemplate
     */
    public function testInvalidArgumentWhenRenderCellTemplate()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Wrong column name specified.");
        $this->customcheckboxes->renderCellTemplate('test');
    }

    /**
     * Column key is not set, so the second condition of the "if" will fail.
     *
     * @covers                   ::renderCellTemplate
     */
    public function testColumnNotExistWhenRenderCellTemplate()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Wrong column name specified.");
        $this->dependencyMocks['elementFactory']->method('create')->willReturn($this->abstractElement);
        $this->abstractElement->method('getForm')->willReturn($this->abstractElement);
        $this->customcheckboxes->renderCellTemplate('checked');
    }

    /**
     * Invalid column name and column key is not set, so the body of the if should not be called
     *
     * @covers                   ::renderCellTemplate
     */
    public function testInvalidArgumentAndUnknownColumnWhenRenderCellTemplate()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Wrong column name specified.");
        $this->dependencyMocks['elementFactory']->method('create')->willReturn($this->abstractElement);
        $actual = $this->customcheckboxes->renderCellTemplate('test');
        static::assertEquals('', $actual);
    }

    /**
     * Basic setup for test
     */
    protected function setUp(): void
    {
        $mockFactory            = new MockFactory($this);
        $objectFactory          = new TestObjectFactory('');
        $this->customcheckboxes = $objectFactory->create(Customcheckboxes::class);
        $this->dependencyMocks  = $objectFactory->getDependencyMocks();
        $this->abstractElement  = $mockFactory->create(AbstractElement::class);
    }
}
