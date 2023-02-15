<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'T3 Newsletter',
    'description' => '',
    'category' => 'plugin',
    'author' => 'Haithem Daoud',
    'author_email' => 'haithemdaoud.se@gmail.com',
    'state' => 'alpha',
    'uploadfolder' => 1,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
           'TYPO3\\T3Newsletter\\' => 'Classes'
        ]
    ],
];