<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */
declare(strict_types=1);

namespace Klarna\AdminSettings\Model\Configurations\Kco;

use Klarna\AdminSettings\Model\Configurations\AbstractConfiguration;
use Klarna\Kco\Model\Payment\Kco;
use Magento\Store\Api\Data\StoreInterface;

/**
 * @internal
 */
class ShippingOptions extends AbstractConfiguration
{
    /**
     * @var string
     */
    public string $paymentCode = Kco::METHOD_CODE;

    /**
     * Returns true if a separate shipping address is allowed to be used
     *
     * @param StoreInterface $store
     * @return bool
     */
    public function isSeparateShippingAddressAllowed(StoreInterface $store): bool
    {
        return $this->getCheckoutFlagValue($store, 'separate_address');
    }

    /**
     * Returns true if the shipping method is shown in the iframe
     *
     * @param StoreInterface $store
     * @return bool
     */
    public function isShippingInIframe(StoreInterface $store): bool
    {
        return $this->getCheckoutFlagValue($store, 'shipping_in_iframe');
    }

    /**
     * Returns true if the TMS configuration override should be disabled.
     *
     * Intended for merchants migrating from a standalone Ingrid iframe integration, so that shipping
     * options aren't presented twice during the transition period.
     *
     * @param StoreInterface $store
     * @return bool
     */
    public function isTmsConfigurationOverrideDisabled(StoreInterface $store): bool
    {
        return $this->getCheckoutFlagValue($store, 'tms_configuration_override_disabled');
    }
}
