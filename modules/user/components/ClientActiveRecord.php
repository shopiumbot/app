<?php

namespace app\modules\user\components;

use app\modules\user\models\User;
use panix\engine\db\ActiveRecord;
use Yii;
use yii\base\Exception;
use yii\console\Application;


class ClientActiveRecord extends ActiveRecord
{
    public static function getDb()
    {
        if (!(Yii::$app instanceof Application)) {
            if (Yii::$app->user->isGuest) {
                return Yii::$app->cache->getOrSet(__CLASS__, function () {
                    $user = User::findByHook(Yii::$app->request->get('hook'));
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
            return parent::getDb();
        }
    }
}
