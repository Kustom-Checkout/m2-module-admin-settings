<?php

/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

declare(strict_types=1);

namespace Klarna\AdminSettings\Test\Integration\Model\System\Config\Backend;

use Klarna\AdminSettings\Model\System\Config\Kco\Backend\Multiselect;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Config\Kco\Backend\Multiselect
 */
class MultiselectTest extends TestCase
{
    /**
     * @var ObjectManagerInterface|null
     */
    private ?ObjectManagerInterface $objectManager = null;

    /**
     * @var Multiselect|null
     */
    private ?Multiselect $model = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->model = $this->objectManager->create(Multiselect::class);
    }

    /**
     * @covers ::beforeSave
     */
    public function testBeforeSaveNotArrayAndMinusValue(): void
    {
        $this->model->setData('value', -1);
        $this->model->beforeSave();

        $this->assertNull($this->model->getValue());
    }

    /**
     * @covers ::beforeSave
     */
    public function testBeforeSaveArrayWithMinusValue(): void
    {
        $this->model->setData('value', [-1]);
        $this->model->beforeSave();

        $this->assertNull($this->model->getValue());
    }

    /**
     * @covers ::beforeSave
     */
    public function testBeforeSaveArrayWithValidValue(): void
    {
        $this->model->setData('value', 'foo');
        $this->model->beforeSave();

        $this->assertEquals('foo', $this->model->getValue());
    }
}
