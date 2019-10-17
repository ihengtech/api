<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'user'
    ]
    /*
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'face',
        'except' => ['update', 'index', 'view', 'delete', 'options', 'create'],
        'extraPatterns' => [
            'POST analysis' => 'analysis',
        ],
    ],
    */
    /*
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'file-manage',
        'except' => ['update', 'index', 'view', 'delete', 'options'],
    ]
    */
];