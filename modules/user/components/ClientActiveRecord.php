<?php

namespace app\modules\user\components;

use app\modules\user\models\User;
use panix\engine\db\ActiveRecord;
use Yii;
use yii\base\Exception;
use yii\console\Application;


class ClientActiveRecord extends ActiveRecord
{
    public static function getDb2()
    {
        if (!(Yii::$app instanceof Application)) {
            if (Yii::$app->user->isGuest) {
                Yii::info('webhook '.Yii::$app->getModule('telegram')->hook_url);
                $container = new \yii\di\Container;
                $container->set('cache', [
                    'class' => 'yii\caching\FileCache',
                    'directoryLevel' => 0,
                    'keyPrefix' => '',
                    'cachePath' => '@runtime/cache/' . Yii::$app->request->get('webhook')
                ]);
                return Yii::$app->cache->getOrSet(Yii::$app->request->get('webhook').__CLASS__, function () {
                    $user = User::findByHook(Yii::$app->request->get('webhook'));
                    if ($user) {
                        return $user->getClientDb();
                    } else {
                        throw new Exception('error client db');
                    }
                });
            } else {
                return Yii::$app->user->getClientDb();
            }
        } else {
            Yii::info('load default db');
            return parent::getDb();
        }
    }
    public static function getDb()
    {
        return Yii::$app->user->getClientDb();
    }
}
