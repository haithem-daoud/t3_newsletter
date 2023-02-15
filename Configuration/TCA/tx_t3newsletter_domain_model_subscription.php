<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

return [
    'ctrl' => [
        'title' => 'Subscription',
        'label' => 'email',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'default_sortby' => 'crdate DESC',
        'versioningWS' => false,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'email',
        'iconfile' => 'EXT:t3_newsletter/newsletter-icon.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, email',
    ],
    'types' => [
        '0' => ['showitem' => 'gender, firstname, lastname, email, company, data_privacy_accepted, email_confirmed, token,
                    --div--;Access, hidden'],
    ],
    'palettes' => [

    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0]
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_t3newsletter_domain_model_subscription',
                'foreign_table_where' => 'AND tx_t3newsletter_domain_model_subscription.pid=###CURRENT_PID### AND tx_t3newsletter_domain_model_subscription.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ]
        ],
        
        'gender' => [
            'exclude' => true,
            'label' => 'Gender',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Select ...', ''],
                    ['male', 'male'],
                    ['female', 'female']
                ],
                'eval' => 'required'
            ]
        ],
        'firstname' => [
            'exclude' => true,
            'label' => 'First Name',
            'config' => [
                'type' => 'input',
                'size' => '30'
            ]
        ],
        'lastname' => [
            'exclude' => true,
            'label' => 'Last Name',
            'config' => [
                'type' => 'input',
                'size' => '30'
            ]
        ],
        'email' => [
            'exclude' => true,
            'label' => 'E-Mail',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'email,required'
            ]
        ],
        'company' => [
            'exclude' => true,
            'label' => 'Company',
            'config' => [
                'type' => 'input',
                'size' => '30'
            ]
        ],
        'data_privacy_accepted' => [
            'exclude' => true,
            'label' => 'Data Privacy Accepted',
            'config' => [
                'type' => 'check',
                'default' => '0',
                'readOnly' => 1
            ]
        ],
        'email_confirmed' => [
            'exclude' => true,
            'label' => 'E-Mail Address Confirmed',
            'config' => [
                'type' => 'check',
                'default' => '0',
                'readOnly' => 1
            ]
        ],
        'token' => [
            'exclude' => true,
            'label' => 'Token',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'readOnly' => 1
            ]
        ],
    ],
];
