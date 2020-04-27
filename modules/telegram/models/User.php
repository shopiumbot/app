<?php

namespace app\modules\telegram\models;


use app\modules\telegram\models\query\UserQuery;
use app\modules\user\components\ClientActiveRecord;
use Yii;

/**
 * This is the model class for table "actions".
 *
 * @property integer $client_chat_id
 * @property string $message
 * @property string $time
 * @property string $direction
 */
class User extends ClientActiveRecord
{
    const MODULE_ID = 'telegram';

    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%telegram__user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_chat_id'], 'required'],
            [['first_name', 'last_name', 'username'], 'safe'],
            //   [['message'], 'string', 'max' => 4100],
        ];
    }

    public function getMessages()
    {
        return $this->hasMany(Message::class, ['user_id' => 'id']);
    }
    public function getChats()
    {
        return $this->hasMany(Message::class, ['chat_id' => 'id']);
    }
    public function getLastMessage()
    {
        return $this->hasOne(Message::class, ['user_id' => 'id'])->orderBy(['date'=>SORT_DESC]);
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
