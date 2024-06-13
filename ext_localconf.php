<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use MiniFranske\FsMediaGallery\Controller\MediaAlbumController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use MiniFranske\FsMediaGallery\Hooks\ProcessDatamapHook;

defined('TYPO3') || die('not TYPO3 env');

$boot = function ($packageKey): void
{
    ExtensionUtility::configurePlugin(
        $packageKey,
        'NestedList',
        [
            MediaAlbumController::class => 'nestedList,showAsset',
        ],
    );

    ExtensionUtility::configurePlugin(
        $packageKey,
        'FlatList',
        [
            MediaAlbumController::class => 'flatList,showAsset',
        ],
    );

    ExtensionUtility::configurePlugin(
        $packageKey,
        'ShowAlbumByConfig',
        [
            MediaAlbumController::class => 'showAlbumByConfig,showAsset',
        ],
    );

    ExtensionUtility::configurePlugin(
        $packageKey,
        'ShowAlbum',
        [
            MediaAlbumController::class => 'showAlbum,showAsset',
        ],
    );

    ExtensionUtility::configurePlugin(
        $packageKey,
        'RandomAsset',
        [
            MediaAlbumController::class => 'randomAsset,showAsset',
        ],
    );

    ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:fs_media_gallery/Configuration/TSConfig/Page.tsconfig"'
    );

    // refresh file tree after changen in media album recored (sys_file_collection)
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        ProcessDatamapHook::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] =
        ProcessDatamapHook::class;
};
$boot('fs_media_gallery');
unset($boot);
