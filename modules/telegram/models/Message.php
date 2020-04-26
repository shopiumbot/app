<?php

namespace app\modules\telegram\models;

use app\modules\telegram\Telegram;
use Yii;

/**
 * This is the model class for table "actions".
 *
 * @property integer $client_chat_id
 * @property string $message
 * @property string $time
 * @property string $direction
 */
class Message extends \yii\db\ActiveRecord
{
    const MODULE_ID = 'telegram';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%telegram__message}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->user->getClientDb();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_chat_id'], 'required'],
         //   [['message'], 'string', 'max' => 4100],
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
    
        ];
    }
}
