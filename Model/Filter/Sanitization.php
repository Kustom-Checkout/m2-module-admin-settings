<?php
/**
 * Copyright 2025 Kustom AB (Originally developed by Klarna Bank AB)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */
declare(strict_types=1);

namespace Klarna\AdminSettings\Model\Filter;

/**
 * @internal
 */
class Sanitization
{
    public const KCO_INPUT_KEYS = [
        'added_checkbox_options' => [
            'merchant_checkbox_text'
        ],
        'url_options' => [
            'failure_url',
            'terms_url',
            'cancellation_terms_url'
        ],
        'klarna_kco_design' => [
            'color_button',
            'color_button_text',
            'color_checkbox',
            'color_checkbox_checkmark',
            'color_header',
            'color_link',
            'radius_border'
        ]
    ];
    public const KCO_PRODUCT_KEY = 'klarna_kco_required';

    /**
     * Sanitizing the KCO input
     *
     * @param array $configData
     * @return array
     */
    public function sanitizeKcoInput(array $configData): array
    {
        return $this->sanitize(self::KCO_PRODUCT_KEY, self::KCO_INPUT_KEYS, $configData);
    }

    /**
     * Sanitizing the input
     *
     * @param string $baseKey
     * @param array $search
     * @param array $configData
     * @return array
     */
    private function sanitize(string $baseKey, array $search, array $configData): array
    {
        if (!isset($configData['groups']['klarna_section']['groups'][$baseKey])) {
            return $configData;
        }

        if (!isset($configData['groups']['klarna_section']['groups'][$baseKey]['groups'])) {
            return $configData;
        }

        foreach ($search as $outerKey => $values) {
            foreach ($values as $innerKey) {
                if (!isset($configData['groups']['klarna_section']['groups'][$baseKey]['groups'][$outerKey])) {
                    continue;
                }
                if (!isset($configData['groups']['klarna_section']['groups'][$baseKey]['groups'][$outerKey]
                    ['fields'][$innerKey]['value'])) {
                    continue;
                }

                $value = $configData['groups']['klarna_section']['groups'][$baseKey]['groups'][$outerKey]
                    ['fields'][$innerKey]['value'];
                if ($value === '') {
                    continue;
                }

                $sanitizedValue = $outerKey === 'added_checkbox_options'
                    ? strip_tags($value)
                    : filter_var(strip_tags($value), FILTER_SANITIZE_URL);
                $configData['groups']['klarna_section']['groups'][$baseKey]['groups'][$outerKey]
                    ['fields'][$innerKey]['value'] = $sanitizedValue;
            }
        }

        return $configData;
    }
}
