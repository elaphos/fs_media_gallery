<?php

declare(strict_types=1);

/*
 * (c) 2024 rc design visual concepts (rc-design.at)
 * _________________________________________________
 * The TYPO3 project - inspiring people to share!
 * _________________________________________________
 */

defined('TYPO3') || die('not TYPO3 env');

$boot = function ($packageKey): void {

    /** @var TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
    $iconRegistry = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Core\Imaging\IconRegistry::class);
};
$boot('fs_media_gallery');
unset($boot);
