<?php
/**
 * Copyright 2025 Kustom AB (Originally developed by Klarna Bank AB)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */
declare(strict_types=1);

namespace Klarna\AdminSettings\Setup\Patch\Data;

use Klarna\AdminSettings\Model\Update\UxRedesign\Api\Manager as ApiManager;
use Klarna\AdminSettings\Model\Update\UxRedesign\General\Manager as GeneralManager;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * @internal
 */
class UxRedesign implements DataPatchInterface
{
    /**
     * @var StoreRepositoryInterface
     */
    private StoreRepositoryInterface $storeRepository;
    /**
     * @var ApiManager
     */
    private ApiManager $apiManager;
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;
    /**
     * @var GeneralManager
     */
    private GeneralManager $generalManager;

    /**
     * @param StoreRepositoryInterface $storeRepository
     * @param ApiManager $apiManager
     * @param GeneralManager $generalManager
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @codeCoverageIgnore
     */
    public function __construct(
        StoreRepositoryInterface $storeRepository,
        ApiManager $apiManager,
        GeneralManager $generalManager,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->storeRepository = $storeRepository;
        $this->apiManager = $apiManager;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->generalManager = $generalManager;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $levels = [ScopeConfigInterface::SCOPE_TYPE_DEFAULT, ScopeInterface::SCOPE_WEBSITES];

        foreach ($this->storeRepository->getList() as $store) {
            if ($store->getCode() === 'admin') {
                continue;
            }

            foreach ($levels as $level) {
                $storeId = '0';
                if ($level === ScopeInterface::SCOPE_WEBSITES) {
                    $storeId = $store->getWebsiteId();
                }

                $this->apiManager->setScope($level);
                $this->apiManager->setScopeCode($storeId);
                $this->apiManager->prepareMappingData();

                $this->apiManager->updateApiMode();
                $this->apiManager->updateRegion();
                $this->apiManager->updateUserName();
                $this->apiManager->updatePassword();
                $this->apiManager->updateClientIdentifier();

                $this->generalManager->setScope($level);
                $this->generalManager->setScopeCode($storeId);
                $this->generalManager->prepareMappingData();

                $this->generalManager->updateAllowSpecificCountries();
                $this->generalManager->updateSpecificCountries();
            }
        }

        $this->moduleDataSetup->getConnection()->endSetup();
        return $this;
    }
}
