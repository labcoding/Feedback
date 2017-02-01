<?php

namespace LabCoding\Feedback;

use LabCoding\Feedback\Action;
use LabCoding\Feedback\InputFilter;
use LabCoding\Feedback\ViewModel\JsonViewModelFactory;

return [

    'entity_map' => require_once __DIR__ . '/entity_map.config.php',
    't4web-crud' => require_once 't4web-crud.config.php',
    'sebaks-view' => require_once 'view-backend.config.php',

    'service_manager' => [
        'factories' => [
            'LabCoding\Feedback\ViewModel\JsonViewModel' => JsonViewModelFactory::class,
        ],
        'invokables' => [
            'LabCoding\Feedback\InputFilter\SendInputFilter' => InputFilter\SendInputFilter::class,
            'LabCoding\Feedback\InputFilter\AnswerInputFilter' => InputFilter\AnswerInputFilter::class,
        ]
    ],

    'controllers' => [
        'factories' => [
            Action\Console\InitController::class => Action\Console\InitControllerFactory::class,
            Action\Backend\AnswerAction\AnswerActionController::class => Action\Backend\AnswerAction\AnswerActionControllerFactory::class,
            Action\Frontend\SendAction\FeedbackController::class => Action\Frontend\SendAction\FeedbackControllerFactory::class,
        ],
    ],

    'router' => [
        'routes' => [
            'admin-feedback-answer' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/admin/feedback/answer/:id',
                    'defaults' => [
                        'controller' => Action\Backend\AnswerAction\AnswerActionController::class,
                    ],
                ],
            ],
            'feedback-create' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/feedback/create',
                    'defaults' => [
                        'controller' => Action\Frontend\SendAction\FeedbackController::class,
                    ],
                ],
            ],
        ]
    ],

    'console' => [
        'router' => [
            'routes' => [
                'feedback-init' => [
                    'options' => [
                        'route' => 'feedback init',
                        'defaults' => [
                            'controller' => Action\Console\InitController::class,
                            'action' => 'run'
                        ],
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];