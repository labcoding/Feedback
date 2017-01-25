<?php

use LabCoding\Feedback\Action\Backend;

return [
    'route-generation' => [
        [
            'entity' => 'feedback',
            'backend' => [
                'actions' => [
                    'list',
                    'delete',
                ],
                'options' => [
                    'list' => [
                        'criteriaValidator' => Backend\ListAction\CriteriaValidator::class
                    ]
                ]
            ],
        ],
    ],
];
