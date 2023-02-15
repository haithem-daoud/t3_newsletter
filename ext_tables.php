<?php
defined ('TYPO3_MODE') || die('Access denied.');

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
call_user_func (
    function () {
        ExtensionManagementUtility::addStaticFile('t3_newsletter', 'Configuration/TypoScript', 'T3 Newsletter');
    }
);