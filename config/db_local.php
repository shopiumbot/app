<?php

return [
    'class' => 'panix\engine\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=shopiumbot',
    'username' => 'root',
    'password' => 'panix47228960',
    'charset' => 'utf8',
    'tablePrefix' => 'cms_',
    'serverStatusCache' => YII_DEBUG ? 0 : 3600,
    'schemaCacheDuration' => YII_DEBUG ? 0 : 3600 * 24,
    'enableSchemaCache' => true,
    'queryCacheDuration' => YII_DEBUG ? 0 : 3600 * 24 * 7,
    'schemaCache' => 'cache',
    //'on afterOpen' => function($event) {
    //$event->sender->createCommand("SET time_zone = '" . date('P') . "'")->execute();
    //$event->sender->createCommand("SET names utf8")->execute();
    //},
];
