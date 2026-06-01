<?php

/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

declare(strict_types=1);

namespace Klarna\AdminSettings\Test\Integration\Model\System\Config\General;

use Klarna\AdminSettings\Model\System\Config\General\Reference;
use Magento\Framework\Data\Form\Element\Text;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\AdminSettings\Model\System\Config\General\Reference
 */
class ReferenceTest extends TestCase
{
    /**
     * @var ObjectManagerInterface|null
     */
    private ?ObjectManagerInterface $objectManager = null;

    /**
     * @var Reference|null
     */
    private ?Reference $model = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->model = $this->objectManager->create(Reference::class);
    }

    /**
     * @covers ::render()
     */
    public function testRenderReturnResult(): void
    {
        $element = $this->objectManager->create(Text::class);

        $docsUrl = 'https://docs.kustom.co/contents/partners/e-commerce-platforms/magento';
        $troubleshootingUrl = 'https://docs.kustom.co/contents/partners/e-commerce-platforms/adobe-commerce/before-you-start/info-and-faq#troubleshooting';
        $logsUrl = 'http://localhost/index.php/klarna/index/logs/';
        $supportUrl = 'http://localhost/index.php/klarna_support/index/support/form/new/';

        $expected =
            '<div>' .
                "<h2 style='color: #303030;'>Version: 1.1.3</h2>" .
                '<ul style="list-style-position: inside;">' .
                    "<li><a href='$docsUrl' target='_blank'>Documentation</a></li>" .
                    "<li><a href='$logsUrl' target='_blank'>Logs</a></li>" .
                    "<li><a href='$supportUrl' target='_blank'>Support</a></li>" .
                    "<li><a href='$troubleshootingUrl' target='_blank'>Troubleshooting</a></li>" .
                '</ul>' .
            '</div>';
        $this->assertSame($expected, $this->model->render($element));
    }
}
