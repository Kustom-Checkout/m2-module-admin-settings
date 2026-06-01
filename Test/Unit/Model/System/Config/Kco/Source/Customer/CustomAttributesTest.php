<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Source\Customer;

use Klarna\AdminSettings\Model\System\Config\Kco\Source\Customer\CustomAttributes;
use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Base\Test\Unit\Mock\TestObjectFactory;
use Magento\Eav\Model\AttributeSearchResults;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Magento\Catalog\Model\Category\Attribute;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Config\Kco\Source\Customer\CustomAttributes
 */
class CustomAttributesTest extends TestCase
{
    /**
     * @var CustomAttributes
     */
    private $model;
    /**
     * @var MockObject[]
     */
    private $dependencyMocks;

    /**
     * @covers ::getAllOptions
     * @testdox If options are already set and we don't want an empty option, return the already set options
     */
    public function testGetAllOptionsNotEmptyNoDefaultValues(): void
    {
        // Running the method once to fill its options parameter for the actual test
        $options = $this->model->getAllOptions(false);

        static::assertEquals($options, $this->model->getAllOptions(false));
    }

    /**
     * @covers ::getAllOptions
     * @testdox If options are already set and we do want an empty option, return the set options + an empty option
     */
    public function testGetAllOptionsNotEmptyWithDefaultValues(): void
    {
        // Running the method once to fill its options parameter for the actual test
        $options = $this->model->getAllOptions(false);

        $expected = array_merge([['value' => '0', 'label' => __('Select')]], $options);
        static::assertEquals($expected, $this->model->getAllOptions());
    }

    /**
     * @covers ::getAllOptions
     * @testdox Return single empty option on Exception
     */
    public function testGetAllOptionsException(): void
    {
        $this->dependencyMocks['searchCriteriaBuilder']->expects(static::atLeastOnce())
            ->method('addFilter')
            ->willThrowException(new \Exception());

        $expected = [[
            'value' => '0',
            'label' => __('Select')
        ]];
        static::assertEquals($expected, $this->model->getAllOptions());
    }

    /**
     * @covers ::getAllOptions
     */
    public function testGetAllOptionsFromFilledAttributeWithEmpty(): void
    {
        $expected = [[
            'value' => '0',
            'label' => __('Select')
        ],[
            'value' => 'foo',
            'label' => 'bar'
        ]];
        static::assertEquals($expected, $this->model->getAllOptions());
    }

    /**
     * @covers ::getAllOptions
     */
    public function testGetAllOptionsFromFilledAttributeWithoutEmpty(): void
    {
        $expected = [[
            'value' => 'foo',
            'label' => 'bar'
        ]];
        static::assertEquals($expected, $this->model->getAllOptions(false));
    }

    protected function setUp(): void
    {
        $mockFactory           = new MockFactory($this);
        $objectFactory         = new TestObjectFactory('');
        $this->model           = $objectFactory->create(CustomAttributes::class, [
            SearchCriteriaBuilder::class => ['addFilter', 'create']
        ]);
        $this->dependencyMocks = $objectFactory->getDependencyMocks();
        $searchCriteria        = $mockFactory->create(SearchCriteria::class);
        $attributeResult       = $mockFactory->create(AttributeSearchResults::class);
        $attributes            = $mockFactory->create(
            Attribute::class,
            [
                'getAttributeCode'
            ],
            [
                'getFrontendLabel'
            ]
        );

        $attributes->method('getAttributeCode')
            ->willReturn('foo');
        $attributes->method('getFrontendLabel')
            ->willReturn('bar');

        $attributeResult->method('getItems')
            ->willReturn([$attributes]);

        $this->dependencyMocks['searchCriteriaBuilder']->method('addFilter')
            ->willReturn($this->dependencyMocks['searchCriteriaBuilder']);
        $this->dependencyMocks['searchCriteriaBuilder']->method('create')
            ->willReturn($searchCriteria);
        $this->dependencyMocks['attributeRepository']->method('getList')
            ->willReturn($attributeResult);
    }
}
