<?php

return [
    /*
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'user'
    ]
    */
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'face-detect',
        'except' => ['update', 'index', 'view', 'delete', 'options', 'create'],
        'extraPatterns' => [
            'GET api-analysis' => 'api-analysis',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'file-manage',
        'except' => ['update', 'index', 'view', 'delete', 'options'],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'merchandise',
        'except' => ['update', 'index', 'view', 'delete', 'options', 'create'],
        'extraPatterns' => [
            'GET api-wares' => 'api-wares',
        ],
    ],
];