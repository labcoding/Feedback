<?php

namespace LabCoding\FeedbackBackend;

use T4web\Admin\ViewModel;
use LabCoding\Feedback\Domain\Feedback;

return [
    'contents' => [
        'admin-feedback-list' => [
            'extend' => 'admin-list',
            'data' => [
                'static' => [
                    'title' => 'Feedback',
                    'icon' => 'fa-info-circle',
                ],
            ],
            'children' => [
                'filter' => [
                    'extend' => 't4web-admin-filter',
                    'data' => [
                        'static' => [
                            'horizontal' => true,
                        ],
                    ],
                    'children' => [
                        'filter-id' => [
                            'template' => 't4web-admin/block/form-element-text',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'id',
                                    'label' => 'Id',
                                ],
                                'fromParent' => [
                                    'id' => 'value'
                                ],
                            ],
                        ],
                        'filter-message' => [
                            'template' => 't4web-admin/block/form-element-text',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'message_like',
                                    'label' => 'Message',
                                ],
                                'fromParent' => [
                                    'message_like' => 'value'
                                ],
                            ],
                        ],
                        'filter-status' => [
                            'template' => 't4web-admin/block/form-element-select',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'status_equalTo',
                                    'label' => 'Status',
                                    'options' =>  ['' => 'All'] + Feedback::$statuses,
                                ],
                                'fromParent' => [
                                    'status_equalTo' => 'value'
                                ],
                            ],
                        ],
                        'filter-date' => [
                            'template' => 't4web-admin/block/form-element-datetime-range',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'createdDt',
                                    'label' => 'Create date range',
                                ],
                                'fromParent' => [
                                    'createdDt_lessThan' => 'lessThen',
                                    'createdDt_greaterThan' => 'greaterThen',
                                ]
                            ],
                        ],
                        'form-button-clear' => [
                            'data' => [
                                'static' => [
                                    'routeName' => 'admin-feedback-list',
                                ],
                            ],
                        ],
                    ],
                ],
                'table' => [
                    'template' => 't4web-admin/block/table',
                    'viewModel' => ViewModel\TableViewModel::class,
                    'data' => [
                        'fromGlobal' => [
                            'result' => 'rowsData',
                        ],
                    ],
                    'children' => [
                        'table-head-row' => [
                            'template' => 't4web-admin/block/table-tr',
                            'data' => [
                                'fromParent' => 'rows',
                            ],
                            'children' => [
                                'table-th-id' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Id',
                                            'width' => '5%',
                                        ],
                                    ],
                                ],
                                'table-th-message' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Message',
                                            'width' => '40%',
                                        ],
                                    ],
                                ],
                                'table-th-createdDt' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Date',
                                            'width' => '15%',
                                        ],
                                    ],
                                ],
                                'table-th-status' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Status',
                                            'width' => '5%',
                                        ],
                                    ],
                                ],
                                'table-th-actions' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Actions',
                                            'width' => '20%',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'table-body-row' => [
                            'viewModel' => ViewModel\TableRowViewModel::class,
                            'template' => 'feedback/admin/block/table-tr-collapse',
                            'data' => [
                                'fromParent' => 'row',
                            ],
                            'children' => [
                                'table-td-id' => [
                                    'template' => 't4web-admin/block/table-td',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'fromParent' => ['id' => 'value'],
                                    ],
                                ],
                                'table-td-message' => [
                                    'template' => 'feedback/admin/block/table-td-message',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'stringLength' => 50
                                        ],
                                        'fromParent' => [
                                            'message' => 'value',
                                        ],
                                    ],
                                ],
                                'table-td-createdDt' => [
                                    'template' => 't4web-admin/block/table-td',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'fromParent' => [
                                            'createdDt' => 'value',
                                        ],
                                    ],
                                ],
                                'table-td-status' => [
                                    'template' => 't4web-admin/block/table-td-labeled',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'colorValueMap' => [
                                                Feedback::STATUS_NEW => 'default',
                                                Feedback::STATUS_ANSWERED => 'success',
                                            ],
                                            'textValueMap' => [
                                                Feedback::STATUS_NEW => Feedback::$statuses[Feedback::STATUS_NEW],
                                                Feedback::STATUS_ANSWERED => Feedback::$statuses[Feedback::STATUS_ANSWERED],
                                            ],
                                        ],
                                        'fromParent' => ['status' => 'value'],
                                    ],
                                ],
                                'table-td-buttons' => [
                                    'template' => 't4web-admin/block/table-td-buttons',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'fromParent' => [
                                            'id' => 'id',
                                            'row' => 'values',
                                        ],
                                    ],
                                    'children' => [
                                        'collapse-button' => [
                                            'template' => 't4web-admin/block/collapse-button',
                                            'capture' => 'button',
                                            'data' => [
                                                'static' => [
                                                    'size' => 'xs',
                                                    'color' => 'info',
                                                    'text' => 'View',
                                                    'icon' => 'info-circle',
                                                ],
                                                'fromParent' => [
                                                    'id' => 'target',
                                                ],
                                            ],
                                        ],
                                        'link-button-answer' => [
                                            'viewModel' => ViewModel\EditButtonViewModel::class,
                                            'template' => 'feedback/admin/block/answer-button',
                                            'capture' => 'button',
                                            'data' => [
                                                'static' => [
                                                    'text' => 'Send answer',
                                                    'color' => 'primary',
                                                    'size' => 'xs',
                                                    'icon' => 'send-o',
                                                ],
                                                'fromParent' => [
                                                    'id' => 'id',
                                                    'values' => 'values',
                                                ],
                                            ],
                                        ],
                                        'link-button-delete' => [
                                            'viewModel' => ViewModel\EditButtonViewModel::class,
                                            'template' => 't4web-admin/block/link-button-with-confirm',
                                            'capture' => 'button',
                                            'data' => [
                                                'static' => [
                                                    'text' => 'Delete',
                                                    'color' => 'danger',
                                                    'size' => 'xs',
                                                    'icon' => 'times',
                                                    'routeName' => 'admin-feedback-delete',
                                                ],
                                                'fromParent' => 'id',
                                            ],
                                        ],
                                    ]
                                ],
                                'table-tr-collapse' => [
                                    'template' => 'feedback/admin/block/table-tr-collapse',
                                    'capture' => 'table-tr-collapse',
                                    'data' => [
                                        'fromParent' => [
                                            'id' => 'target',
                                            'row' => 'values',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'childrenDynamicLists' => [
                        'table-body-row' => 'rowsData',
                    ],
                ],
                'paginator' => [
                    'extend' => 't4web-admin-paginator',
                    'viewModel' => 'Feedback\Feedback\ViewModel\PaginatorViewModel',
                ],
            ],
        ],
    ],

    'blocks' => [
        't4web-admin-sidebar-menu' => [
            'children' => [
                [
                    'extend' => 't4web-admin-sidebar-menu-item',
                    'capture' => 'item',
                    'data' => [
                        'static' => [
                            'label' => 'Feedback',
                            'route' => 'admin-feedback-list',
                            'icon' => 'fa-info-circle',
                        ],
                    ],
                    'children' => [],
                ],
            ],
        ],
    ],
];

