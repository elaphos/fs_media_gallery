<?php

use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') || die('not TYPO3 env');

$boot = function ($packageKey) {
    // Add CSH
    // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    //     'tt_content.pi_flexform.fsmediagallery_mediagallery.list',
    //     'EXT:' . $packageKey . '/Resources/Private/Language/locallang_csh_flexforms.xlf'
    // );
    /** @var IconRegistry $iconRegistry */
    $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
};
$boot('fs_media_gallery');
unset($boot);
