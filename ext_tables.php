<?php

/*
 * Copyright (C) 2024 Christian Racan
 * ----------------------------------------------
 * new version of sf_media_gallery for TYPO3 v12
 * The TYPO3 project - inspiring people to share!
 * ----------------------------------------------
 */

defined('TYPO3') || die('not TYPO3 env');

$boot = function ($packageKey) {
    // Add CSH
    // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    //     'tt_content.pi_flexform.fsmediagallery_mediagallery.list',
    //     'EXT:' . $packageKey . '/Resources/Private/Language/locallang_csh_flexforms.xlf'
    // );

    /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
};
$boot('fs_media_gallery');
unset($boot);
