<?php

$db = YII_DEBUG ? dirname(__DIR__) . '/config/db_local.php' : dirname(__DIR__) . '/config/db.php';
$config = [
    'id' => 'common',
    'name' => 'PIXELION CMS',
    'basePath' => dirname(__DIR__) . '/../',
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@uploads' => '@app/web/uploads',
    ],
    'bootstrap' => [
        'log',
        'maintenanceMode',
        'panix\engine\BootstrapModule'
    ],
    'controllerMap' => [
        'site' => 'panix\engine\controllers\WebController',
        'backend' => 'panix\engine\controllers\AdminController',
        'maintenance' => 'panix\engine\maintenance\controllers\MaintenanceController'
    ],
    'modules' => [
        'plugins' => [
            'class' => 'panix\mod\plugins\Module',
            'pluginsDir' => [
                '@panix/engine/plugins',
            ]
        ],
        'rbac' => [
            'class' => 'panix\mod\rbac\Module',
            //'as access' => [
            //    'class' => panix\mod\rbac\filters\AccessControl::class
            //],
        ],
        'admin' => ['class' => 'panix\mod\admin\Module'],
        'user' => ['class' => 'app\modules\user\Module'],
        'contacts' => ['class' => 'panix\mod\contacts\Module'],
        'seo' => ['class' => 'panix\mod\seo\Module'],
        'images' => ['class' => 'app\modules\images\Module'],
        'discounts' => ['class' => 'app\modules\discounts\Module'],
        'telegram' => ['class' => 'app\modules\telegram\Module'],
        'shop' => ['class' => 'app\modules\shop\Module'],
        'csv' => ['class' => 'app\modules\csv\Module'],
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
        'geoip' => ['class' => 'panix\engine\components\geoip\GeoIP'],
        'formatter' => ['class' => 'panix\engine\i18n\Formatter'],
        'maintenanceMode' => [
            'class' => 'panix\engine\maintenance\MaintenanceMode',
            // Allowed roles
            //'roles' => [
            //    'admin',
            //],
            //Retry-After header
            // 'retryAfter' => 120 //or Wed, 21 Oct 2015 07:28:00 GMT for example
        ],
        'assetManager' => [
            'forceCopy' => YII_DEBUG,
            // 'bundles' => [
            //'yii\jui\JuiAsset' => ['css' => []],
            // 'yii\jui\JuiAsset' => [
            //'js' => [
            //'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js'
            //]
            //  ],
            // ],
            //'appendTimestamp' => true
        ],
        'plugins' => [
            'class' => panix\mod\plugins\components\PluginsManager::class,
            'appId' => panix\mod\plugins\BasePlugin::APP_BACKEND,
            // by default
            'enablePlugins' => true,
            'shortcodesParse' => true,
            'shortcodesIgnoreBlocks' => [
                '<pre[^>]*>' => '<\/pre>',
                // '<div class="content[^>]*>' => '<\/div>',
            ]
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
            // 'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'mailer' => [
            'class' => 'panix\engine\Mailer',
            'htmlLayout' => 'layouts/html'
        ],
        'log' => ['class' => 'panix\engine\log\Dispatcher'],
        'languageManager' => ['class' => 'panix\engine\ManagerLanguage'],
        'settings' => ['class' => 'panix\engine\components\Settings'],
        'urlManager' => require(__DIR__ . '/urlManager.php'),
        'db' => require($db),
     /*   'clientDb' => function () {
            $user = Yii::$app->get('user');
            if ($user = Yii::$app->get('user', false)) {
                if($user->getIsGuest()){
                    $user = \app\modules\user\models\User::findByHook(Yii::$app->request->get('webhook'));
                }else{

                }
            }


            Yii::$app->setComponents([
                'clientSettings' => [
                    'class' => 'panix\engine\components\Settings',
                    'db' => 'clientDb',
                ],
            ]);
            return Yii::createObject([
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=localhost;dbname=' . $user->db_name,
                'username' => $user->db_user,
                'password' => $user->db_password,
                'charset' => 'utf8',
                'tablePrefix' => 'client_',
                'serverStatusCache' => YII_DEBUG ? 0 : 3600,
                'schemaCacheDuration' => YII_DEBUG ? 0 : 3600 * 24,
                'queryCacheDuration' => YII_DEBUG ? 0 : 3600 * 24 * 7,
                'enableSchemaCache' => true,
                'schemaCache' => 'cache'
            ]);
        },*/
    ],
    /*'as access' => [
        'class' => panix\mod\rbac\filters\AccessControl::class,
        'allowActions' => [
           // '/*',
            'admin/*',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],*/
    'params' => require(__DIR__ . '/params.php'),
];

return $config;