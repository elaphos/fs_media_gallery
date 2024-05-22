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
    TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $packageKey,
        'NestedList',
        [
            MiniFranske\FsMediaGallery\Controller\MediaAlbumController::class => 'nestedList,showAsset',
        ],
    );

    TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $packageKey,
        'FlatList',
        [
            MiniFranske\FsMediaGallery\Controller\MediaAlbumController::class => 'flatList,showAsset',
        ],
    );

    TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $packageKey,
        'ShowAlbumByConfig',
        [
            MiniFranske\FsMediaGallery\Controller\MediaAlbumController::class => 'showAlbumByConfig,showAsset',
        ],
    );

    TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $packageKey,
        'ShowAlbum',
        [
            MiniFranske\FsMediaGallery\Controller\MediaAlbumController::class => 'showAlbum,showAsset',
        ],
    );

    TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $packageKey,
        'RandomAsset',
        [
            MiniFranske\FsMediaGallery\Controller\MediaAlbumController::class => 'randomAsset,showAsset',
        ],
    );

    // TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    //     '@import "EXT:fs_media_gallery/Configuration/TSConfig/Page.tsconfig"'
    // );

    // refresh file tree after changen in media album recored (sys_file_collection)
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        MiniFranske\FsMediaGallery\Hooks\ProcessDatamapHook::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] =
        MiniFranske\FsMediaGallery\Hooks\ProcessDatamapHook::class;
};
$boot('fs_media_gallery');
unset($boot);
