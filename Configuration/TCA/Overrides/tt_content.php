<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die('not TYPO3 env');

$extensionName = 'FsMediaGallery';
$plugins = [
    'NestedList',
    'FlatList',
    'ShowAlbumByConfig',
    'ShowAlbum',
    'RandomAsset',
];

foreach ($plugins as $pluginName)
{
    ExtensionUtility::registerPlugin(
        $extensionName,
        $pluginName,
        'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_be.xlf:mediagallery.'. lcfirst($pluginName) .'.title'
    );
    $piKey = strtolower($extensionName) . '_' . strtolower($pluginName);
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$piKey] = 'layout,select_key,pages,recursive';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$piKey] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        $piKey,
        'FILE:EXT:fs_media_gallery/Configuration/FlexForms/flexform_'. strtolower($pluginName) .'.xml'
    );
}
