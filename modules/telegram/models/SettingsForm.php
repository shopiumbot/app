<?php

namespace app\modules\telegram\models;

use panix\engine\SettingsModel;
use Yii;
class SettingsForm extends SettingsModel
{

    public static $category = 'telegram';

    protected $module = 'telegram';
    protected $component = 'clientSettings';

    public $api_token;
    public $bot_name;
    public $empty_cart_text;
    public $empty_history_text;
    public $bot_admins;

    public function init()
    {
        $this->component = 'clientSettings';
        parent::init();
    }

    public function rules()
    {
        return [
            [['api_token', 'bot_name', 'empty_cart_text', 'empty_history_text'], "required"],
            [['api_token', 'bot_name', 'empty_cart_text', 'empty_history_text', 'bot_admins'], 'string'],
        ];
    }


    /**
     * @inheritdoc
     */
    public static function defaultSettings()
    {
        return [
            'empty_cart_text' => 'Ваша корзина пустая',
            'empty_history_text' => 'Ваша история пустая Воспользуйтесь каталогом чтобы ее наполнить',
            'bot_admins' => '',
        ];
    }

}
