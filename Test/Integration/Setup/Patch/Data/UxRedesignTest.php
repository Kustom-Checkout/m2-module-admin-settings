<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */
declare(strict_types=1);

namespace Klarna\AdminSettings\Test\Integration\Setup\Patch\Data;

use Klarna\AdminSettings\Model\Configurations\General;
use Klarna\AdminSettings\Model\Configurations\Osm;
use Klarna\AdminSettings\Setup\Patch\Data\UxRedesign;
use Klarna\Base\Test\Integration\Helper\GenericTestCase;
use Klarna\AdminSettings\Model\Configurations\Api;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\App\Cache\Manager;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\ResourceConnection;
use Klarna\Base\Exception as KlarnaException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @internal
 */
class UxRedesignTest extends GenericTestCase
{
    /**
     * @var UxRedesign
     */
    private $uxRedesign;
    /**
     * @var Api
     */
    private $apiConfig;
    /**
     * @var Store
     */
    private $store;
    /**
     * @var Manager
     */
    private $cacheManager;
    /**
     * @var ConfigInterface
     */
    private $configWriter;
    /**
     * @var EncryptorInterface
     */
    private $encryptor;
    /**
     * @var Osm
     */
    private $osmConfig;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var
     */
    private $connection;
    /**
     * @var General
     */
    private $generalConfig;

    /**
     * @magentoConfigFixture default/klarna/api/api_version na
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default USD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKcoPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyUsd(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'USD'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'USD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'USD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'USD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'USD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version na
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default USD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKcoProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyUsd(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'USD'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'USD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'USD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'USD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'USD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version na
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default CAD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKcoPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyCad(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'CAD'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'CAD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'CAD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'CAD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'CAD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version na
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default CAD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKcoProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyCad(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'CAD'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'CAD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'CAD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'CAD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'CAD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version na
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default MXN
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKcoPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyMxn(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'MXN'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'MXN'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'MXN'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'MXN'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'MXN'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version na
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default MXN
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKcoProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyMxn(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'MXN'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'MXN'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'MXN'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'MXN'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'MXN'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version uk
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default EUR
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyUkKcoPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyEur(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('eu', $this->apiConfig->getRegion($this->store, 'EUR'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'EUR'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'EUR'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'EUR'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'EUR'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version uk
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default EUR
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyUkKcoProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyEur(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('eu', $this->apiConfig->getRegion($this->store, 'EUR'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'EUR'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'EUR'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'EUR'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'EUR'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version nl
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default EUR
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNlKcoPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyEur(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('eu', $this->apiConfig->getRegion($this->store, 'EUR'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'EUR'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'EUR'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'EUR'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'EUR'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version nl
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default EUR
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNlKcoProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyEur(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('eu', $this->apiConfig->getRegion($this->store, 'EUR'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'EUR'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'EUR'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'EUR'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'EUR'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version dach_v3
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default EUR
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyDachV3KcoPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyEur(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('eu', $this->apiConfig->getRegion($this->store, 'EUR'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'EUR'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'EUR'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'EUR'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'EUR'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version dach_v3
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default EUR
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyDachV3KcoProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyEur(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('eu', $this->apiConfig->getRegion($this->store, 'EUR'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'EUR'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'EUR'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'EUR'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'EUR'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_na
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default USD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKpPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyUsd(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'USD'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'USD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'USD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'USD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'USD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_na
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default USD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKpProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyUsd(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'USD'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'USD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'USD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'USD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'USD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_na
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default CAD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKpPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyCad(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'CAD'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'CAD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'CAD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'CAD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'CAD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_na
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default MXN
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKpProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyMxn(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'MXN'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'MXN'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'MXN'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'MXN'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'MXN'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_eu
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default EUR
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyEuKpPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyEur(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('eu', $this->apiConfig->getRegion($this->store, 'EUR'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'EUR'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'EUR'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'EUR'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'EUR'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_eu
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default EUR
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyEuKpProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyEur(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('eu', $this->apiConfig->getRegion($this->store, 'EUR'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'EUR'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'EUR'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'EUR'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'EUR'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_oc
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default AUD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOcKpPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyAud(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('oc', $this->apiConfig->getRegion($this->store, 'AUD'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'AUD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'AUD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'AUD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'AUD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_oc
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default AUD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOcKpProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyAud(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('oc', $this->apiConfig->getRegion($this->store, 'AUD'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'AUD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'AUD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'AUD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'AUD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_oc
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default NZD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOcKpPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyNzd(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('oc', $this->apiConfig->getRegion($this->store, 'NZD'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'NZD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'NZD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'NZD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'NZD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_oc
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default NZD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOcKpProductionWithMidAndPasswordAndKecAndOsmClientIdentifierWithCurrencyNzd(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('oc', $this->apiConfig->getRegion($this->store, 'NZD'));
        static::assertFalse($this->apiConfig->isTestMode($this->store, 'NZD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'NZD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'NZD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'NZD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/klarna/api/shared_secret fghij
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default NZD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNoApiVersionGivenImpliesRegionNotWrittenToTheDatabase(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();

        $this->clearCache();

        static::expectException(KlarnaException::class);
        $this->apiConfig->getRegion($this->store, 'NZD');
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_oc
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/shared_secret fghij
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default NZD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNoMerchantIdGivenImpliesUserNameNotWrittenToTheDatabase(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();

        $this->clearCache();
        static::assertEmpty($this->apiConfig->getUserName($this->store, 'AUD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_oc
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default NZD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNoSharedSecretIdGivenImpliesPasswordNotWrittenToTheDatabase(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();

        $this->clearCache();
        static::assertEmpty($this->apiConfig->getPassword($this->store, 'AUD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_oc
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/klarna/api/shared_secret fghij
     * @magentoConfigFixture default/currency/options/default NZD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNoKecClientIdentifierAndNoOsmDataIdGivenImpliesClientIdentifierNotWrittenToTheDatabase(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();

        $this->clearCache();
        static::assertEmpty($this->apiConfig->getClientIdentifier($this->store, 'AUD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_oc
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/klarna/api/shared_secret fghij
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/currency/options/default NZD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyKecClientIdentifierAndNotOsmDataIdGivenImpliesKecClientIdentifierWrittenToTheDatabase(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();

        $this->clearCache();
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'NZD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_oc
     * @magentoConfigFixture default/klarna/api/test_mode 0
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/klarna/api/shared_secret fghij
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     * @magentoConfigFixture default/currency/options/default NZD
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNoKecClientIdentifierButOsmDataIdGivenImpliesOsmDataIdWrittenToTheDatabase(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();

        $this->clearCache();
        static::assertEquals('pqrst', $this->apiConfig->getClientIdentifier($this->store, 'NZD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version na
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNaKcoPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierAndPlatformDefaultCurrencyIsUsed(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'USD'));
        static::assertEquals('1', $this->apiConfig->isTestMode($this->store, 'USD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'USD'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'USD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'USD'));
    }

    /**
     * @magentoConfigFixture default/klarna/api/api_version kp_eu
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id abcde
     * @magentoConfigFixture default/payment/kec/client_identifier klmno
     * @magentoConfigFixture default/klarna/osm/data_id pqrst
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyEuKpPlaygroundWithMidAndPasswordAndKecAndOsmClientIdentifierAndPlatformDefaultCurrencyIsUsed(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $expectedPassword = 'fghij';
        $this->encryptAndSavePassword($expectedPassword);

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('eu', $this->apiConfig->getRegion($this->store, 'EUR'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'EUR'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'EUR'));
        static::assertEquals($expectedPassword, $this->apiConfig->getPassword($this->store, 'EUR'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'EUR'));
    }

    /**
     * @magentoConfigFixture default/klarna/osm/product_enabled 0
     * @magentoConfigFixture default/klarna/osm/cart_enabled 0
     * @magentoConfigFixture default/klarna/osm/footer_enabled 0
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOsmProductDisabledCartDisabledFooterDisabled(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertFalse($this->osmConfig->isEnabledOnProductPage($this->store));
        static::assertFalse($this->osmConfig->isEnabledOnCartPage($this->store));
        static::assertFalse($this->osmConfig->isEnabledOnFooter($this->store));
    }

    /**
     * @magentoConfigFixture default/klarna/osm/product_enabled 1
     * @magentoConfigFixture default/klarna/osm/cart_enabled 0
     * @magentoConfigFixture default/klarna/osm/footer_enabled 0
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOsmProductEnabledCartDisabledFooterDisabled(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertTrue($this->osmConfig->isEnabledOnProductPage($this->store));
        static::assertFalse($this->osmConfig->isEnabledOnCartPage($this->store));
        static::assertFalse($this->osmConfig->isEnabledOnFooter($this->store));
    }

    /**
     * @magentoConfigFixture default/klarna/osm/product_enabled 0
     * @magentoConfigFixture default/klarna/osm/cart_enabled 1
     * @magentoConfigFixture default/klarna/osm/footer_enabled 0
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOsmProductDisabledCartEnabledFooterDisabled(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertFalse($this->osmConfig->isEnabledOnProductPage($this->store));
        static::assertTrue($this->osmConfig->isEnabledOnCartPage($this->store));
        static::assertFalse($this->osmConfig->isEnabledOnFooter($this->store));
    }

    /**
     * @magentoConfigFixture default/klarna/osm/product_enabled 1
     * @magentoConfigFixture default/klarna/osm/cart_enabled 1
     * @magentoConfigFixture default/klarna/osm/footer_enabled 0
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOsmProductEnabledCartEnabledFooterDisabled(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertTrue($this->osmConfig->isEnabledOnProductPage($this->store));
        static::assertTrue($this->osmConfig->isEnabledOnCartPage($this->store));
        static::assertFalse($this->osmConfig->isEnabledOnFooter($this->store));
    }

    /**
     * @magentoConfigFixture default/klarna/osm/product_enabled 0
     * @magentoConfigFixture default/klarna/osm/cart_enabled 0
     * @magentoConfigFixture default/klarna/osm/footer_enabled 1
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOsmProductDisabledCartDisabledFooterEnabled(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertFalse($this->osmConfig->isEnabledOnProductPage($this->store));
        static::assertFalse($this->osmConfig->isEnabledOnCartPage($this->store));
        static::assertTrue($this->osmConfig->isEnabledOnFooter($this->store));
    }

    /**
     * @magentoConfigFixture default/klarna/osm/product_enabled 1
     * @magentoConfigFixture default/klarna/osm/cart_enabled 0
     * @magentoConfigFixture default/klarna/osm/footer_enabled 1
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOsmProductEnabledCartDisabledFooterEnabled(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertTrue($this->osmConfig->isEnabledOnProductPage($this->store));
        static::assertFalse($this->osmConfig->isEnabledOnCartPage($this->store));
        static::assertTrue($this->osmConfig->isEnabledOnFooter($this->store));
    }

    /**
     * @magentoConfigFixture default/klarna/osm/product_enabled 0
     * @magentoConfigFixture default/klarna/osm/cart_enabled 1
     * @magentoConfigFixture default/klarna/osm/footer_enabled 1
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOsmProductDisabledCartEnabledFooterEnabled(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertFalse($this->osmConfig->isEnabledOnProductPage($this->store));
        static::assertTrue($this->osmConfig->isEnabledOnCartPage($this->store));
        static::assertTrue($this->osmConfig->isEnabledOnFooter($this->store));
    }

    /**
     * @magentoConfigFixture default/klarna/osm/product_enabled 1
     * @magentoConfigFixture default/klarna/osm/cart_enabled 1
     * @magentoConfigFixture default/klarna/osm/footer_enabled 1
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyOsmProductEnabledCartEnabledFooterEnabled(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertTrue($this->osmConfig->isEnabledOnProductPage($this->store));
        static::assertTrue($this->osmConfig->isEnabledOnCartPage($this->store));
        static::assertTrue($this->osmConfig->isEnabledOnFooter($this->store));
    }

    /**
     * @magentoConfigFixture default/payment/klarna_kp/allowspecific 1
     * @magentoConfigFixture default/payment/klarna_kp/specificcountry DE,US,UK
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyMovingCountryWithValueSettingsFromKpToGeneral(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertTrue($this->generalConfig->isCountryAllowed($this->store, 'DE'));
        static::assertTrue($this->generalConfig->isCountryAllowed($this->store, 'US'));
        static::assertFalse($this->generalConfig->isCountryAllowed($this->store, 'FR'));

        static::assertEquals('1', $this->getDatabaseValue('klarna/general/allow_specific_countries', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
        static::assertEquals('DE,US,UK', $this->getDatabaseValue('klarna/general/specific_countries', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
    }

    /**
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyMovingCountryWithoutValueSettingsFromKpToGeneral(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertTrue($this->generalConfig->isCountryAllowed($this->store, 'DE'));
        static::assertTrue($this->generalConfig->isCountryAllowed($this->store, 'US'));

        static::assertEmpty($this->getDatabaseValue('klarna/general/allow_specific_countries', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
        static::assertEmpty($this->getDatabaseValue('klarna/general/specific_countries', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
    }

    /**
     * @magentoConfigFixture current_website klarna/api/api_version na
     * @magentoConfigFixture current_website klarna/api/test_mode 1
     * @magentoConfigFixture current_website klarna/api/merchant_id abcde
     * @magentoConfigFixture current_website payment/kec/client_identifier klmno
     * @magentoConfigFixture current_website currency/options/default USD
     * @magentoConfigFixture default/klarna/osm/product_enabled 1
     * @magentoConfigFixture default/klarna/osm/cart_enabled 1
     * @magentoConfigFixture default/klarna/osm/footer_enabled 1
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyMultiStoreDifferentValuesOnDefaultAndWebsiteLevel(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'USD'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'USD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'USD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'USD'));
        static::assertTrue($this->osmConfig->isEnabledOnProductPage($this->store));
        static::assertTrue($this->osmConfig->isEnabledOnCartPage($this->store));
        static::assertTrue($this->osmConfig->isEnabledOnFooter($this->store));

        static::assertEquals('na', $this->getDatabaseValue('klarna/api/region', ScopeInterface::SCOPE_WEBSITES, '1'));
        static::assertEquals('1', $this->getDatabaseValue('klarna/api_us/api_mode', ScopeInterface::SCOPE_WEBSITES, '1'));
        static::assertEquals('abcde', $this->getDatabaseValue('klarna/api_us/username_playground', ScopeInterface::SCOPE_WEBSITES, '1'));
        static::assertEquals('klmno', $this->getDatabaseValue('klarna/api_us/client_identifier_playground', ScopeInterface::SCOPE_WEBSITES, '1'));
        static::assertEquals('product,cart,footer', $this->getDatabaseValue('klarna/osm/position', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));

        static::assertEmpty($this->getDatabaseValue('klarna/api/region', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
        static::assertEmpty($this->getDatabaseValue('klarna/api_us/api_mode', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
        static::assertEmpty($this->getDatabaseValue('klarna/api_us/username_playground', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
        static::assertEmpty($this->getDatabaseValue('klarna/api_us/client_identifier_playground', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
        static::assertEmpty($this->getDatabaseValue('klarna/osm/position', ScopeInterface::SCOPE_WEBSITES, '1'));
    }

    /**
     * @magentoConfigFixture current_website klarna/api/api_version na
     * @magentoConfigFixture current_website klarna/api/test_mode 1
     * @magentoConfigFixture current_website klarna/api/merchant_id abcde
     * @magentoConfigFixture current_website payment/kec/client_identifier klmno
     * @magentoConfigFixture current_website currency/options/default USD
     * @magentoConfigFixture default/klarna/api/api_version kp_eu
     * @magentoConfigFixture default/klarna/api/test_mode 1
     * @magentoConfigFixture default/klarna/api/merchant_id ttttttt
     * @magentoConfigFixture default/payment/kec/client_identifier zzzzzzz
     * @magentoConfigFixture default/currency/options/default EUR
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyMultiStoreIntersectionOfValuesOnDefaultAndWebsiteLevel(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $this->uxRedesign->apply();
        $this->clearCache();

        static::assertEquals('na', $this->apiConfig->getRegion($this->store, 'USD'));
        static::assertTrue($this->apiConfig->isTestMode($this->store, 'USD'));
        static::assertEquals('abcde', $this->apiConfig->getUserName($this->store, 'USD'));
        static::assertEquals('klmno', $this->apiConfig->getClientIdentifier($this->store, 'USD'));

        static::assertEquals('na', $this->getDatabaseValue('klarna/api/region', ScopeInterface::SCOPE_WEBSITES, '1'));
        static::assertEquals('1', $this->getDatabaseValue('klarna/api_us/api_mode', ScopeInterface::SCOPE_WEBSITES, '1'));
        static::assertEquals('abcde', $this->getDatabaseValue('klarna/api_us/username_playground', ScopeInterface::SCOPE_WEBSITES, '1'));
        static::assertEquals('klmno', $this->getDatabaseValue('klarna/api_us/client_identifier_playground', ScopeInterface::SCOPE_WEBSITES, '1'));
        static::assertEquals('ttttttt', $this->getDatabaseValue('klarna/api_eu/username_playground', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
        static::assertEquals('zzzzzzz', $this->getDatabaseValue('klarna/api_eu/client_identifier_playground', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));

        static::assertEmpty($this->getDatabaseValue('klarna/api_us/username_playground', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
        static::assertEmpty($this->getDatabaseValue('klarna/api_us/client_identifier_playground', ScopeConfigInterface::SCOPE_TYPE_DEFAULT, '0'));
        static::assertEmpty($this->getDatabaseValue('klarna/api_eu/username_playground', ScopeInterface::SCOPE_WEBSITES, '1'));
        static::assertEmpty($this->getDatabaseValue('klarna/api_eu/client_identifier_playground', ScopeInterface::SCOPE_WEBSITES, '1'));

    }

    private function getDatabaseValue(string $path, string $scope, string $scopeId): string
    {
        $query = "SELECT value FROM core_config_data where path='" . $path . "' and scope='" . $scope . "' and scope_id='" . $scopeId . "'";
        $result = $this->connection->fetchAll($query);
        if (!isset($result[0])) {
            return '';
        }
        return $result[0]['value'];
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testApplyNoLegacyDataGivenImpliesNoExceptionThrown(): void
    {
        $this->markTestSkipped('Skipped for now since the logic is not anymore that relevant');

        $result = true;
        try {
            $this->uxRedesign->apply();
            $this->clearCache();
        } catch (\Exception $e) {
            $result = false;
        }

        static::assertTrue($result);
    }

    private function clearCache(): void
    {
        $this->cacheManager->clean(['config']);
        $this->cacheManager->flush(['config']);
    }

    private function encryptAndSavePassword(string $password): void
    {
        $this->configWriter->saveConfig(
            'klarna/api/shared_secret',
            $this->encryptor->encrypt($password),
            $this->store->getCode(),
            $this->store->getStoreId()
        );
        $this->clearCache();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->uxRedesign = $this->objectManager->get(UxRedesign::class);
        $this->apiConfig = $this->objectManager->get(Api::class);
        $this->osmConfig = $this->objectManager->get(Osm::class);
        $this->generalConfig = $this->objectManager->get(General::class);

        $storeManager = $this->objectManager->get(StoreManagerInterface::class);
        $this->store = $storeManager->getStore(1);

        $this->cacheManager = $this->objectManager->get(Manager::class);
        $this->configWriter = $this->objectManager->get(ConfigInterface::class);
        $this->encryptor = $this->objectManager->get(EncryptorInterface::class);

        $this->scopeConfig = $this->objectManager->get(ScopeConfigInterface::class);
        $this->connection = $this->objectManager->get(ResourceConnection::class)->getConnection();
    }
}
