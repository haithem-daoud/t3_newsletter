<?php 
defined('TYPO3_MODE') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionUtility::registerPlugin(
    'T3Newsletter',
    'Subscription',
    'T3 Newsletter'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['t3newsletter_subscription'] = 'select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['t3newsletter_subscription'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue('t3newsletter_subscription', 'FILE:EXT:t3_newsletter/Configuration/FlexForms/Subscription.xml');