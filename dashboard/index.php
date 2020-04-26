<?php

error_reporting(E_ALL);
//Timezone
date_default_timezone_set("UTC");

// comment out the following two lines when deployed to production
if (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1','178.212.194.135'])) {
    $env = 'dev';
    $debug = true;
} else {
    $env = 'prod';
    $debug = false;
}

defined('COMMON_PATH') or define('COMMON_PATH', __DIR__ . '/../../common-dev');
defined('YII_DEBUG') or define('YII_DEBUG', $debug);
defined('YII_ENV') or define('YII_ENV', $env);

require COMMON_PATH . '/vendor/autoload.php';


require COMMON_PATH . '/vendor/yiisoft/yii2/Yii.php';
Yii::$classMap['panix\engine\controllers\AdminController'] = COMMON_PATH.'/components/controllers/AdminController.php';
Yii::$classMap['panix\engine\controllers\CommonController'] = COMMON_PATH.'/components/controllers/CommonController.php';
Yii::$classMap['panix\mod\admin\widgets\sidebar\BackendNav'] = COMMON_PATH.'/vendor/shopium/mod-admin/widgets/sidebar/BackendNav.php';

$config = yii\helpers\ArrayHelper::merge(
    require COMMON_PATH . '/config/common.php',
    require COMMON_PATH . '/config/web.php',
    require __DIR__ . '/config/web.php'
);

$app = new \core\components\WebApplication($config);


$app->run();