<?php
/**
 * Copyright 2025 Kustom AB (Originally developed by Klarna Bank AB)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Setup\Patch\Data;

use Klarna\AdminSettings\Setup\Patch\Data\UxRedesign;
use Klarna\Base\Test\Unit\Mock\TestCase;
use Magento\Store\Model\Store;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Setup\Patch\Data\UxRedesign
 */
class UxRedesignTest extends TestCase
{
    /**
     * @var UxRedesign
     */
    private UxRedesign $uxRedesign;
    /**
     * @var Store
     */
    private Store $store;

    public function testApplyCallingMethodApiPreparingData(): void
    {
        $this->dependencyMocks['apiManager']->expects(static::atLeastOnce())
            ->method('prepareMappingData');
        $this->uxRedesign->apply();
    }

    public function testApplyCallingMethodUpdateApiMode(): void
    {
        $this->dependencyMocks['apiManager']->expects(static::atLeastOnce())
            ->method('updateApiMode');
        $this->uxRedesign->apply();
    }

    public function testApplyCallingMethodUpdateRegion(): void
    {
        $this->dependencyMocks['apiManager']->expects(static::atLeastOnce())
            ->method('updateRegion');
        $this->uxRedesign->apply();
    }

    public function testApplyCallingMethodUpdateUserName(): void
    {
        $this->dependencyMocks['apiManager']->expects(static::atLeastOnce())
            ->method('updateUserName');
        $this->uxRedesign->apply();
    }

    public function testApplyCallingMethodUpdatePassword(): void
    {
        $this->dependencyMocks['apiManager']->expects(static::atLeastOnce())
            ->method('updatePassword');
        $this->uxRedesign->apply();
    }

    public function testApplyCallingMethodUpdateClientIdentifier(): void
    {
        $this->dependencyMocks['apiManager']->expects(static::atLeastOnce())
            ->method('updateClientIdentifier');
        $this->uxRedesign->apply();
    }

    public function testApplyCallingMethodUpdateAllowSpecificCountries(): void
    {
        $this->dependencyMocks['generalManager']->expects(static::atLeastOnce())
            ->method('updateAllowSpecificCountries');
        $this->uxRedesign->apply();
    }

    public function testApplyCallingMethodUpdateSpecificCountries(): void
    {
        $this->dependencyMocks['generalManager']->expects(static::atLeastOnce())
            ->method('updateSpecificCountries');
        $this->uxRedesign->apply();
    }

    public function testApplySettingCorrectScopeAndScopeCode(): void
    {
        $this->dependencyMocks['apiManager']->expects(static::atLeastOnce())
            ->method('setScope')
            ->willReturnCallback(fn($scope) =>
                match($scope) {
                    'default' => null,
                    'websites' => null
                }
            );
        $this->dependencyMocks['apiManager']->expects(static::atLeastOnce())
            ->method('setScopeCode')
            ->willReturnCallback(fn($scope) =>
                match($scope) {
                    '0' => null,
                    '1' => null
                }
            );
        $this->dependencyMocks['generalManager']->expects(static::atLeastOnce())
            ->method('setScope')
            ->willReturnCallback(fn($scope) =>
                match($scope) {
                    'default' => null,
                    'websites' => null
                }
            );
        $this->dependencyMocks['generalManager']->expects(static::atLeastOnce())
            ->method('setScopeCode')
            ->willReturnCallback(fn($scope) =>
                match($scope) {
                    '0' => null,
                    '1' => null
                }
            );

        $this->uxRedesign->apply();
    }

    public function testApplyNotCallingAnyMethodSinceStoreIsAnAdminStore(): void
    {
        $this->store->method('getCode')
            ->willReturn('admin');

        $this->dependencyMocks['apiManager']->expects(static::never())
            ->method('prepareMappingData');
        $this->dependencyMocks['apiManager']->expects(static::never())
            ->method('updateApiMode');
        $this->dependencyMocks['apiManager']->expects(static::never())
            ->method('updateRegion');
        $this->dependencyMocks['apiManager']->expects(static::never())
            ->method('updateUserName');
        $this->dependencyMocks['apiManager']->expects(static::never())
            ->method('updatePassword');
        $this->dependencyMocks['apiManager']->expects(static::never())
            ->method('updateClientIdentifier');
    }

    protected function setUp(): void
    {
        $this->uxRedesign = parent::setUpMocks(UxRedesign::class);

        $this->store = $this->mockFactory->create(Store::class);
        $this->store->method('getWebsiteId')
            ->willReturn('1');
        $this->dependencyMocks['storeRepository']->method('getList')
            ->willReturn([$this->store]);

        $adapter = $this->mockFactory->create(AdapterInterface::class);
        $this->dependencyMocks['moduleDataSetup']->method('getConnection')
            ->willReturn($adapter);
        $this->store->method('getWebsiteId')
            ->willReturn('1');
    }
}
