<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */
declare(strict_types=1);

namespace Klarna\AdminSettings\Model\System\Message;

use Klarna\AdminSettings\Model\Configurations\Kco\Checkout;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @internal
 */
class Config
{
    /**
     * @var Checkout
     */
    private Checkout $kcoConfiguration;
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @param Checkout $kcoConfiguration
     * @param StoreManagerInterface $storeManager
     * @codeCoverageIgnore
     */
    public function __construct(Checkout $kcoConfiguration, StoreManagerInterface $storeManager)
    {
        $this->kcoConfiguration = $kcoConfiguration;
        $this->storeManager = $storeManager;
    }

    /**
     * Check to see if any store or default has a Klarna payment method enabled
     *
     * @return bool
     */
    public function isKlarnaEnabledInAnyStore()
    {
        $storeCollection = $this->storeManager->getStores(true);
        foreach ($storeCollection as $store) {
            if ($this->isAnyKlarnaProductEnabledForStore($store)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns true if KCO is enabled in the target store
     *
     * @param StoreInterface $store
     * @return bool
     */
    public function isAnyKlarnaProductEnabledForStore(StoreInterface $store): bool
    {
        return $this->kcoConfiguration->isEnabled($store);
    }
}
