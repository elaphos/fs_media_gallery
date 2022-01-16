<?php
defined('TYPO3_MODE') || die();

$boot = function ($packageKey) {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'MiniFranske.' . $packageKey,
        'Mediagallery',
        [
            \MiniFranske\FsMediaGallery\Controller\MediaAlbumController::class => 'index,nestedList,flatList,showAlbum,showAlbumByConfig,showAsset,random',
        ],
        // non-cacheable actions
        [
            \MiniFranske\FsMediaGallery\Controller\MediaAlbumController::class => 'random',
        ]
    );

    // Page TSConfig
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $packageKey . '/Configuration/TSConfig/Page.ts">');

    // Module header bar buttons
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Backend\Template\Components\ButtonBar']['getButtonsHook']['FsMediaGallery'] =
        'MiniFranske\\FsMediaGallery\\Hooks\\DocHeaderButtonsHook->moduleTemplateDocHeaderGetButtons';

    // refresh file tree after changen in media album recored (sys_file_collection)
    $GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        \MiniFranske\FsMediaGallery\Hooks\ProcessDatamapHook::class;
    $GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] =
        \MiniFranske\FsMediaGallery\Hooks\ProcessDatamapHook::class;

    // Page module hook
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['fsmediagallery_mediagallery']['fs_media_gallery'] =
        'MiniFranske\\FsMediaGallery\\Hooks\\PageLayoutView->getExtensionSummary';

    $GLOBALS['TYPO3_CONF_VARS']['BE']['ContextMenu']['ItemProviders'][1547740001] = \MiniFranske\FsMediaGallery\ContextMenu\ItemProviders\FsMediaGalleryProvider::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess'][] = \MiniFranske\FsMediaGallery\Hooks\BackendControllerHook::class . '->addJavaScript';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['realurlAliasMediaAlbumsSlug']
        = \MiniFranske\FsMediaGallery\Updates\RealurlAliasMediaAlbumsSlug::class; // Recommended before 'populateMedialAlbumsSlug'

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['populateMedialAlbumsSlug']
        = \MiniFranske\FsMediaGallery\Updates\PopulateMedialAlbumsSlug::class;
};
$boot('fs_media_gallery');
unset($boot);
