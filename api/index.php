<?php


defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

//Yii::$classMap['app\engine\api\Application'] = __DIR__.'/../engine/api/Application.php';

$config = require(__DIR__ . '/config/main.php');

$application = new yii\web\Application($config);
//$application = new \app\engine\api\Application($config);


$application->run();
