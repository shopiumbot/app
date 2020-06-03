<?php

if (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '178.212.194.135'])) {
    $env = 'dev';
    $debug = true;
} else {
    $env = 'prod';
    $debug = false;
}

defined('YII_DEBUG') or define('YII_DEBUG', $debug);
defined('YII_ENV') or define('YII_ENV', $env);


require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');


$config = require(__DIR__ . '/config/main.php');

$application = new yii\web\Application($config);
$application->run();
