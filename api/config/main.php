<?php

$params = array_merge(
    require(__DIR__ . '/../../config/params.php')
);

return [
    'id' => 'api',
    'name' => 'Api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'site',
    /* 'modules' => [
         'shop' => [
             'basePath' => '@app/modules/shop/api/v1',
             'class' => 'app\modules\shop\api\v1\Module'
         ]
     ],*/
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\Module'
        ],
        'shop' => [
            'class' => 'app\modules\shop\Module'
        ],
        'v1' => ['class' => 'api\modules\v1\Module'],
        //'v2' => ['class' => 'api\modules\v2\Module']

    ],
    'aliases' => [
        '@api' => dirname(dirname(__DIR__)) . '/api',
        '@app' => dirname(dirname(__DIR__)),
        '@uploads' => '@app/web/uploads',
    ],
    'controllerNamespace' => 'api\controllers',
    'vendorPath' => dirname(__DIR__) . '/../vendor',
    'controllerMap' => [
        'site' => 'api\controllers\WebController',
        'user' => 'api\controllers\UserController',
    ],
    'components' => [
        'cache' => [
            'directoryLevel' => 0,
            'keyPrefix' => '',
            'class' => 'yii\caching\FileCache', //DummyCache
        ],
        'user' => [

            'class' => 'app\modules\user\components\WebUser',
            'enableAutoLogin' => false,
            'enableSession' => false
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
        'db' => [
            'class' => 'panix\engine\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=shopiumbot',
            'username' => 'root',
            'password' => 'root',
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
        'clientDb' => [
            'class' => 'panix\engine\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=shopiumbot_jonggolf',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'tablePrefix' => 'pf26_',
            'serverStatusCache' => YII_DEBUG ? 0 : 3600,
            'schemaCacheDuration' => YII_DEBUG ? 0 : 3600 * 24,
            'queryCacheDuration' => YII_DEBUG ? 0 : 3600 * 24 * 7,
            'enableSchemaCache' => true,
            'schemaCache' => 'cache'
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => 'm38y535nygo8wytowertg78gm4wt',
        ],

        'urlManager' => [
            //'baseUrl'=>'/api',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            //http://yii-api.loc/api/v1/countries
            'rules' => [


                //'GET <controller:[\w-]+>' => '<controller>/index',
                //'GET <controller:[\w-]+>/<id:\d+>' => '<controller>/view',


                'GET <module:[\w-]+>/<controller:[\w-]+>' => '<module>/<controller>/index',
                'GET <module:[\w-]+>/<controller:[\w-]+>/<id:\d+>' => '<module>/<controller>/view',
                'PUT <module:[\w-]+>/<controller:[\w-]+>/<id:\d+>' => '<module>/<controller>/update',
                'DELETE <module:[\w-]+>/<controller:[\w-]+>/<id:\d+>' => '<module>/<controller>/delete',

                //'POST api/device' => 'api/device/create',
                //'<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<module>/<controller>/<action>',
                //'GET api/search-dev/<serilal:[\w-]+>' => 'api/search-dev',
                //'GET api/dev-models/type/<type_id:\d+>/brand/<brand_id:\d+>' => 'api/dev-models',
                //'<module:[\w-]+>/<controller:[\w-]+>' => '<module>/<controller>',


                [
                    'pattern' => '/',
                    'route' => 'site/index',
                ],
               /* [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['user'],
                    //'prefix' => 'api',
                    'pluralize' => false,
                    'tokens' => ['{id}' => '<id:\\w+>']
                ],*/
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['product'],
                    //'prefix' => 'api',
                    'pluralize' => false,
                    'tokens' => ['{id}' => '<id:\\w+>'],
                    //'except' => ['manufacturer','index'],
                ],
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['order'],
                    //'prefix' => 'api',
                    'pluralize' => false,
                    'tokens' => ['{id}' => '<id:\\w+>'],
                    //'except' => ['manufacturer','index'],
                ],


                /*[
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/order',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                ]*/

            ],
        ]
    ],
    'params' => $params,
];



