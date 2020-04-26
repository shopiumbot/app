<?php

$config = [
    'id' => 'client',
    'vendorPath' => COMMON_PATH . '/vendor',
    'basePath' => dirname(__DIR__),
    'runtimePath' => dirname(__DIR__).'/runtime',
    'aliases' => [
        '@core' => COMMON_PATH,
		'@uploads' => dirname(__DIR__).'/web/uploads',
		'@runtime' => dirname(__DIR__).'/runtime',
    ],
    'components' => [
        'db' => require_once('_db.php'),
        'request' => [
            'cookieValidationKey' => 'fpsiKaSs1Mcb6zwlsUZwuhqScBs5UgPQ',
        ],

    ],
    'params' => yii\helpers\ArrayHelper::merge([
        'plan_id' => 2,
    ],require(COMMON_PATH . '/config/params.php')),
];

return $config;

