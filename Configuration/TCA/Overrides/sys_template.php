<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die('not TYPO3 env');

// Media Gellery typoscript
ExtensionManagementUtility::addStaticFile(
    'fs_media_gallery',
    'Configuration/TypoScript',
    'Media Gallery'
);
// Add Theme 'Bootstrap3'
ExtensionManagementUtility::addStaticFile(
    'fs_media_gallery',
    'Configuration/TypoScript/Themes/Bootstrap3',
    'Media Gallery Theme \'Bootstrap3\''
);
