<?php
defined('TYPO3') || die('not TYPO3 env');


$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-mediagal'] =
    'apps-pagetree-folder-contains-mediagal';

// Add module icon for Folder (page-contains)
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    'MediaGalleries',
    'mediagal',
    'apps-pagetree-folder-contains-mediagal'
];
