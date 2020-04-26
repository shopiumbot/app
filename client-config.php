<?php

$db = YII_DEBUG ? __DIR__ . '/config/db_local.php' : __DIR__ . '/config/db.php';



$config = [
    'id' => 'console',
    'name' => 'PIXELION CMS',
    'basePath' => __DIR__,
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@uploads' => '@app/web/uploads',
    ],
    'bootstrap' => [
        'log',
        'panix\engine\BootstrapModule'
    ],
	'controllerMap' => [
        'migrate' => ['class' => 'panix\engine\console\controllers\MigrateController',
            'migrationPath' => ['@app/client_migrations'],
        ]
    ],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'user' => ['class' => 'app\modules\user\Module'],
       // 'contacts' => ['class' => 'panix\mod\contacts\Module'],
        'images' => ['class' => 'app\modules\images\Module'],
        'discounts' => ['class' => 'app\modules\discounts\Module'],
        'telegram' => ['class' => 'app\modules\telegram\Module'],
        'shop' => ['class' => 'app\modules\shop\Module'],
        'cart' => ['class' => 'app\modules\cart\Module'],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest', 'user'],
        ],
        'img' => [
            'class' => 'panix\engine\components\ImageHandler',
        ],
        'telegram' => [
            'class' => 'app\modules\telegram\components\Telegram',
        ],
        'formatter' => ['class' => 'panix\engine\i18n\Formatter'],
        'request' => [
            'class' => 'yii\console\Request',
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
        'session' => [

            'class' => '\panix\engine\web\DbSession',
            'timeout' => 3600,
            'cookieParams' => ['httponly' => true, 'lifetime' => 3600 * 4],
            //'class' => '\yii\web\DbSession',
            //'writeCallback'=>['panix\engine\web\DbSession', 'writeFields']
        ],

        'cache' => [
            'directoryLevel' => 0,
            'keyPrefix' => '',
            'class' => 'yii\caching\FileCache', //DummyCache
        ],
        'user' => [
            'class' => 'app\modules\user\components\WebUser',
			'enableSession' => false,
            'enableAutoLogin' => false,
            // 'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'log' => ['class' => 'panix\engine\log\Dispatcher'],
        'settings' => ['class' => 'panix\engine\components\Settings'],
        'db' => [
            'class' => 'panix\engine\db\Connection',
            'dsn' => 'mysql:host=corner.mysql.tools;dbname=corner_bot57',
            'username' => 'corner_bot57',
            'password' => 'rdF7@U_77z',
            'charset' => 'utf8',
            'tablePrefix' => 'client_',
            'serverStatusCache' => YII_DEBUG ? 0 : 3600,
            'schemaCacheDuration' => YII_DEBUG ? 0 : 3600 * 24,
            'queryCacheDuration' => YII_DEBUG ? 0 : 3600 * 24 * 7,
            'enableSchemaCache' => true,
            'schemaCache' => 'cache'
        ],
    ],
];

return $config;