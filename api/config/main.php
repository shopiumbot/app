<?php

$params = array_merge(
    require(__DIR__ . '/../../config/params.php')
);

return [
    'id' => 'api',
    'name'=>'Api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'defaultRoute'=> 'site',
   /* 'modules' => [
        'shop' => [
            'basePath' => '@app/modules/shop/api/v1',
            'class' => 'app\modules\shop\api\v1\Module'
        ]
    ],*/
	'aliases' => [
        '@api' => dirname(dirname(__DIR__)) . '/api',
    ],
    'controllerNamespace' => 'api\controllers',
    'vendorPath' => dirname(__DIR__).'/../vendor',
    'controllerMap' => [
        'site' => 'api\controllers\WebController',
        'user' => 'api\controllers\UserController',
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'default' => 'default.php',
                    ],
                ],
                'app/*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@vendor/panix/engine/messages',
                    'fileMap' => [
                        'app/default' => 'default.php',
                        'app/admin' => 'admin.php',
                        'app/month' => 'month.php',
                        'app/error' => 'error.php',
                        'app/geoip_country' => 'geoip_country.php',
                        'app/geoip_city' => 'geoip_city.php',
                    ],
                ],
            ],
        ],
        'db'=>[
            'class' => 'panix\engine\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=shopiumbot',
            'username' => 'root',
            'password' => '47228960panix',
            'charset' => 'utf8',
            'tablePrefix' => 'm90f_',
            'serverStatusCache' => YII_DEBUG ? 0 : 3600,
            'schemaCacheDuration' => YII_DEBUG ? 0 : 3600 * 24,
            'queryCacheDuration' => YII_DEBUG ? 0 : 3600 * 24 * 7,
            'enableSchemaCache' => true,
            'schemaCache' => 'cache'
            //'on afterOpen' => function($event) {
            //$event->sender->createCommand("SET time_zone = '" . date('P') . "'")->execute();
            //$event->sender->createCommand("SET names utf8")->execute();
            //},
        ],
        /*'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],*/

        'urlManager' => [
            //'baseUrl'=>'/api',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            //http://yii-api.loc/api/v1/countries
            'rules' => [
                [
                    'pattern' => '/',
                    'route' => 'site/index',
                ],
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['user'],
                    //'prefix' => 'api',
                    'pluralize'=>false,
                    //'tokens' => [
                    //    '{id}' => '<id:\\w+>'
                    // ]
                ]
            ],
        ]
    ],
    'params' => $params,
];



