<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */
declare(strict_types=1);

namespace Klarna\AdminSettings\Test\Unit\Model;

use Klarna\AdminSettings\Model\AdminLevel;
use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\AdminLevel
 */
class AdminLevelTest extends TestCase
{
    /**
     * @var AdminLevel
     */
    private AdminLevel $adminLevel;
    /**
     * @var array
     */
    private array $dependencyMocks;

    public function testGetScopeStoreIdIsZeroImpliesReturningDefault(): void
    {
        static::assertEquals('default', $this->adminLevel->getScope());
    }

    public function testGetScopeStoreIdIsNotZeroImpliesReturningWebsite(): void
    {
        $this->dependencyMocks['request']->method('getParam')
            ->willReturn(1);
        static::assertEquals('websites', $this->adminLevel->getScope());
    }

    public function testGetStoreIdParamNotSetImpliesReturningZero(): void
    {
        static::assertEquals(0, $this->adminLevel->getStoreId());
    }

    public function testGetStoreIdParamIsSetImpliesReturningParamValue(): void
    {
        $this->dependencyMocks['request']->method('getParam')
            ->willReturn(1);
        static::assertEquals(1, $this->adminLevel->getStoreId());
    }

    protected function setUp(): void
    {
        $mockFactory = new MockFactory($this);
        $objectFactory = new TestObjectFactory('');

        $this->adminLevel = $objectFactory->create(AdminLevel::class);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
    }
}
