<?php
defined ('TYPO3_MODE') || die('Access denied.');

use TYPO3\T3Newsletter\Controller\RegistrationController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;

call_user_func (
    function () {
        ExtensionUtility::configurePlugin (
            'T3Newsletter',
            'subscription',
            [ RegistrationController::class => 'index,confirm' ],
            [ RegistrationController::class => 'index,confirm' ]
        );

        $iconRegistry = GeneralUtility::makeInstance (IconRegistry::class);

        $iconRegistry->registerIcon (
            "t3newsletter_subscription",
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:t3_newsletter/Resources/Public/Icons/plugin.gif']
        );
    }
);