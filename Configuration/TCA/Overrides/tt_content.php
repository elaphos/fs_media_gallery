<?php

/*
 * Copyright (C) 2024 Christian Racan
 * ----------------------------------------------
 * new version of sf_media_gallery for TYPO3 v12
 * The TYPO3 project - inspiring people to share!
 * ----------------------------------------------
 */

defined('TYPO3') || die('not TYPO3 env');

// Nested List Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'fsMediaGallery',
    'NestedList',
    'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_be.xlf:mediagallery.nestedList.title'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['fsmediagallery_nestedlist'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['fsmediagallery_nestedlist'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'fsmediagallery_nestedlist',
    'FILE:EXT:fs_media_gallery/Configuration/FlexForms/flexform_nestedlist.xml'
);

// Flat List Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'fsMediaGallery',
    'FlatList',
    'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_be.xlf:mediagallery.flatList.title'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['fsmediagallery_flatlist'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['fsmediagallery_flatlist'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'fsmediagallery_flatlist',
    'FILE:EXT:fs_media_gallery/Configuration/FlexForms/flexform_flatlist.xml'
);

// Show Album By Config Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'fsMediaGallery',
    'ShowAlbumByConfig',
    'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_be.xlf:mediagallery.showAlbumByConfig.title'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['fsmediagallery_showalbumbyconfig'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['fsmediagallery_showalbumbyconfig'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'fsmediagallery_showalbumbyconfig',
    'FILE:EXT:fs_media_gallery/Configuration/FlexForms/flexform_showalbumbyconfig.xml'
);

// Show Album Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'fsMediaGallery',
    'ShowAlbum',
    'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_be.xlf:mediagallery.showAlbum.title'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['fsmediagallery_showalbum'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['fsmediagallery_showalbum'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'fsmediagallery_showalbum',
    'FILE:EXT:fs_media_gallery/Configuration/FlexForms/flexform_showalbum.xml'
);

// Show AlbumRandom Asset Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'fsMediaGallery',
    'RandomAsset',
    'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_be.xlf:mediagallery.randomAsset.title'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['fsmediagallery_randomasset'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['fsmediagallery_randomasset'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'fsmediagallery_randomasset',
    'FILE:EXT:fs_media_gallery/Configuration/FlexForms/flexform_randomasset.xml'
);
