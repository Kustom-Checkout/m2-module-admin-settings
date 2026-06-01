<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Source;

use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use Klarna\AdminSettings\Model\System\Config\Kco\Source\Externalmethods;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Config\Kco\Source\Externalmethods
 */
class ExternalmethodsTest extends TestCase
{

    /**
     * @var Externalmethods
     */
    private $subject;

    /**
     * @var MockObject[]
     */
    private $dependencyMocks;

    /**
     * @covers ::toOptionArray
     */
    public function testToOptionArrayFromEmptyValue(): void
    {
        $this->dependencyMocks['base']->method('toOptionArray')
            ->willReturn([]);

        $expected = [
            ['value' => -1, 'label' => ' ']
        ];
        static::assertEquals($expected, $this->subject->toOptionArray());
    }

    /**
     * @covers ::toOptionArray
     */
    public function testToOptionArrayFromNotEmptyValue(): void
    {
        $this->dependencyMocks['base']->method('toOptionArray')
            ->willReturn([
                ['value' => '0', 'label' => 'foo']
            ]);

        $expectedOptions = [
            ['value' => -1, 'label' => ' '],
            ['value' => '0', 'label' => 'foo']
        ];
        static::assertEquals($expectedOptions, $this->subject->toOptionArray());
    }

    protected function setUp(): void
    {
        $mockFactory           = new MockFactory($this);
        $objectFactory         = new TestObjectFactory('');
        $this->subject         = $objectFactory->create(Externalmethods::class);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
    }
}
