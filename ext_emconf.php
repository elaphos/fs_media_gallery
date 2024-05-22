<?php

/*
 * Copyright (C) 2024 Christian Racan
 * ----------------------------------------------
 * new version of sf_media_gallery for TYPO3 v12
 * The TYPO3 project - inspiring people to share!
 * ----------------------------------------------
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Media Gallery',
    'description' => 'A media gallery based on the FAL integration of TYPO3.
Show your media assets from your local or remote storage as a gallery of albums.',
    'category' => 'plugin',
    'author' => 'Frans Saris',
    'author_email' => 'franssaris@gmail.com',
    'author_company' => '',
    'state' => 'stable',
    'version' => '4.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.8-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
