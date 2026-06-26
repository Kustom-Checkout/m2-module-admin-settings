<?php

/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\AdminSettings\Test\Unit\Model\System\Config\Orderlines\Source;

use Klarna\AdminSettings\Model\System\Config\Orderlines\Source\Customproductattributes;
use Magento\Catalog\Model\ProductAttributeSearchResults;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute as AttributeAlias;
use Magento\Eav\Model\Entity\Attribute\FrontendLabel;
use Magento\Framework\Api\Search\SearchCriteria;
use Klarna\Base\Test\Unit\Mock\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Config\Orderlines\Source\Customproductattributes
 */
class CustomproductattributesTest extends TestCase
{
    /**
     * @var Customproductattributes
     */
    private $model;

    /**
     * @var ProductAttributeSearchResults|MockObject
     */
    private $listInfo;

    protected function setUp(): void
    {
        $this->model = parent::setUpMocks(Customproductattributes::class);

        $searchCriteria = $this->createMock(SearchCriteria::class);
        $this->dependencyMocks['searchCriteriaBuilder']->method('create')->willReturn($searchCriteria);
        $this->listInfo = $this->createMock(ProductAttributeSearchResults::class);
        $this->dependencyMocks['productAttributeRepository']->method('getList')->willReturn($this->listInfo);
    }

    /**
     * @covers ::toOptionArray()
     * @covers ::extractAdminStoreFrontendLabel()
     */
    public function testToOptionArrayWithFrontendLabels(): void
    {
        $productAttribute = $this->getProductAttributeMock();
        $this->listInfo->method('getItems')->willReturn([$productAttribute]);
        $productAttribute->method('getAttributeCode')->willReturn('some_attribute_code');
        $label = $this->createMock(FrontendLabel::class);
        $productAttribute->method('getFrontendLabels')->willReturn([$label]);
        $label->method('getLabel')->willReturn('Some label');
        $label->method('getStoreId')->willReturn(0);
        $this->assertNotEmpty($this->model->toOptionArray());
    }

    /**
     * @covers ::toOptionArray()
     */
    public function testToOptionArrayReturnsCachedResult(): void
    {
        $productAttribute = $this->getProductAttributeMock();
        $this->listInfo->expects($this->once())->method('getItems')->willReturn([$productAttribute]);
        $productAttribute->expects($this->once())->method('getAttributeCode')->willReturn('some_attribute_code');
        $label = $this->createMock(FrontendLabel::class);
        $productAttribute->expects($this->once())->method('getFrontendLabels')->willReturn([$label]);
        $label->method('getLabel')->willReturn('Some label');
        $label->method('getStoreId')->willReturn(0);
        // Call to generate cached result
        $this->model->toOptionArray();
        // Call a second time to ensure cached result used
        $this->assertNotEmpty($this->model->toOptionArray());
    }

    /**
     * Generate a product attribute mock
     *
     * @return AttributeAlias
     */
    private function getProductAttributeMock()
    {
        return $this->getMockBuilder(AttributeAlias::class)
            ->onlyMethods([
                'getAttributeCode',
                'getFrontendLabels'
            ])
             ->disableOriginalConstructor()
             ->getMock();
    }
}
