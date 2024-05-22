<?php

/*
 * Copyright (C) 2024 Christian Racan
 * ----------------------------------------------
 * new version of sf_media_gallery for TYPO3 v12
 * The TYPO3 project - inspiring people to share!
 * ----------------------------------------------
 */

defined('TYPO3') || die('not TYPO3 env');

// Media Gellery typoscript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'fs_media_gallery',
    'Configuration/TypoScript',
    'Media Gallery'
);
// Add Theme 'Bootstrap3'
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'fs_media_gallery',
    'Configuration/TypoScript/Themes/Bootstrap3',
    'Media Gallery Theme \'Bootstrap3\''
);
