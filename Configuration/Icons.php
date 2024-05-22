<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024 Christian Racan
 * ----------------------------------------------
 * new version of sf_media_gallery for TYPO3 v12
 * The TYPO3 project - inspiring people to share!
 * ----------------------------------------------
 */

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'apps-pagetree-folder-contains-mediagal' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:fs_media_gallery/Resources/Public/Icons/mediagallery.svg',
    ],
    'tcarecords-sys_file_collection-folder' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:fs_media_gallery/Resources/Public/Icons/mediagallery.svg',
    ],
    'action-edit-album' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:fs_media_gallery/Resources/Public/Icons/mediagallery-edit.svg',
    ],
    'action-add-album' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:fs_media_gallery/Resources/Public/Icons/mediagallery-add.svg',
    ],
    'content-mediagallery' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:fs_media_gallery/Resources/Public/Icons/mediagallery.svg',
    ],
];
