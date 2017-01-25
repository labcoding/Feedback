<?php

namespace LabCoding\Feedback;

use LabCoding\Feedback;
use LabCoding\Feedback\Action;

return [

    'entity_map' => require __DIR__ . '/entity_map.config.php',
    't4web-crud' => include 't4web-crud.config.php',
    'sebaks-view' => array_merge_recursive(
        include 'view-backend.config.php'
    ),

    'service_manager' => [
        'factories' => [
            Feedback\ViewModel\JsonViewModel::class => Feedback\ViewModel\JsonViewModelFactory::class,
        ],
        'invokables' => [
            Action\Frontend\SendAction\SendInputFilter::class => Action\Frontend\SendAction\SendInputFilter::class,
            Action\Backend\AnswerAction\AnswerInputFilter::class => Action\Backend\AnswerAction\AnswerInputFilter::class,
        ]
    ],

    'controllers' => [
        'factories' => [
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

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];