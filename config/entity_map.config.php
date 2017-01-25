<?php

namespace LabCoding\Feedback;

return [
    'Feedback' => [
        'entityClass' => Domain\Feedback::class,
        'table' => 'feedback',
        'primaryKey' => 'id',
        'columnsAsAttributesMap' => [
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'message' => 'message',
            'answer' => 'answer',
            'created_dt' => 'createdDt',
            'updated_dt' => 'updatedDt',
            'status' => 'status',
        ],
        'criteriaMap' => [
            'id' => 'id_equalTo',
        ]
    ],
];
