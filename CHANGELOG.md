# Changelog

## 1.3.0 / 2026-08-14

### Breaking changes

* None

### Features / changes

* KUSTOM-96: Support for the full checkout feature
* KUSTOM-89: A new admin field ("Disable TMS configuration override") under Kustom Checkout → Shipping Options,
  for merchants migrating from a standalone Ingrid (or other TMS) iframe integration.

### Fixes

* None

## 1.2.0 / 2026-06-26

### Breaking changes

* None

### Features / changes

* KUSTOM-93: Loosened up PHP version constraint to allow installing the package on Magento 2.4.9
  and PHP 8.5. Adjusted integration and unit tests in the package to run on currently supported
  Magento, PHP and PHPUnit versions.
* KUSTOM-94: Updated labels and strings from Klarna to Kustom in few places.

### Fixes

* None

## 1.1.4 / 2026-04-22

* KUSTOM-88 DEPRECATED Hide/Disable Klarna Payments, On-Site Messaging and Express Checkout

## 1.1.3 / 2026-03-13

* KUSTOM-52 Hide/Disable Sign in with Klarna
* KUSTOM-56 Fix merchant checkbox text sanitization to preserve spaces and special characters 

## 1.1.2 / 2026-02-18

* KUSTOM-42 Remove obsolete "Client identifier" field from API credentials

## 1.1.1 / 2026-01-15

* KUSTOM-37 Changing the direct linking on the admin panel to Kustom  

## 1.1.0 / 2025-11-10

* KUSTOM-33 Change documentation URLs in admin panel
* KUSTOM-33 Removing the unused endpoints which were used to by Klarna

## 1.0.14 / 2025-06-03

* PPP-2016 Change wording of Klarna extension description

## 1.0.13 / 2025-05-21

* PPP-2055 Compatibility with AC 2.4.8 and PHP 8.4

## 1.0.12 / 2025-04-23

* PPP-1814 Added Interoperability functionality

## 1.0.11 / 2025-04-03

* PPP-1796 Add Klarna Express Checkout to mini cart
* PPP-1879 Create unit tests for all classes who extends Klarna\AdminSettings\Block\Adminhtml\System\Config\Checkbox

## 1.0.10 / 2025-03-26

* PPP-1580 Added helper for the Plugins API
* PPP-1903 Fetch available Klarna features from Klarna API

## 1.0.9 / 2025-02-11

* PPP-1983 Increased version because of new dependencies

## 1.0.8 / 2025-01-22

* PPP-1799 bring back "sort order" for KP
* PPP-1859 Simplified unit tests by using a helper which includes the mocking logic.

## 1.0.7 / 2024-12-03

* PPP-1873 Update Privacy Policy link text

## 1.0.6 / 2024-11-05

* PPP-1790 Add link to Klarna privacy policy in general settings
* PPP-1830 List required and default activated scopes for Sign in with Klarna

## 1.0.5 / 2024-10-18

* PPP-1714 Simplify composer.json files
* PPP-1731 Moved class \Klarna\Base\Plugin\ConfigPlugin to the AdminSettings module

## 1.0.4 / 2024-09-26

* PPP-1637 Readded the ability to enable and disable the file logging in the settings.

## 1.0.3 / 2024-08-21

* PPP-1625 Updated phpunit.xml and fixed warnings in the unit tests

## 1.0.2 / 2024-08-12

* PPP-754 Added Sign-in with Klarna

## 1.0.1 / 2024-07-26

* PPP-1553 Make the extension compatible with Adobe Commerce app assurance program requirements
* PPP-1575 Improve KP performance by using a different approach to place order

## 1.0.0 / 2024-06-20

* PPP-1437 Updated the admin UX and changed internally the API credentials handling

## 1.0.0 / XXXX-XX-XX

* PPP-1437 Created the module
