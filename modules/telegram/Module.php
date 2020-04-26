<?php

namespace app\modules\telegram;

use Yii;
use yii\base\UserException;
use yii\helpers\Url;
use panix\engine\WebModule;
use yii\web\GroupUrlRule;

/**
 * telegram module definition class
 */
class Module extends WebModule implements \yii\base\BootstrapInterface
{
    public $api_token = null;
    public $bot_name = null;
    public $hook_url;
    public $password = null;
    public $userCommandsPath = '@telegram/commands/UserCommands';
    public $timeBeforeResetChatHandler = 0;
    public $db = 'db';
    public $options = [];

    public $icon = 'telegram-outline';
    /**
     * @inheritdoc
     */

    public function getDsnAttribute($name)
    {
        if (preg_match('/' . $name . '=([^;]*)/', Yii::$app->db->dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\telegram\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $config = Yii::$app->settings->get('telegram');

        if (isset($config->api_token))
            $this->api_token = $config->api_token;

        if (isset($config->bot_name))
            $this->bot_name = $config->bot_name;

        if (isset($config->password))
            $this->password = $config->password;

        if (!(Yii::$app instanceof \yii\console\Application)) {
            $this->hook_url = 'https://' . Yii::$app->request->getServerName() . '/telegram/hook';

            if (empty($this->hook_url))
                throw new UserException('You must set hook_url');
        }

        parent::init();

        $this->options = [
            'initChat' => Url::to(['/telegram/default/init-chat']),
            'destroyChat' => Url::to(['/telegram/default/destroy-chat']),
            'getAllMessages' => Url::to(['/telegram/chat/get-all-messages']),
            'getLastMessages' => Url::to(['/telegram/chat/get-last-messages']),
            'initialMessage' => \Yii::t('telegram/default', 'Write your question...'),
        ];

    }

    public function bootstrap($app)
    {
        $config = Yii::$app->settings->get('telegram');
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'shopium\mod\telegram\commands';
        }

        $groupUrlRule = new GroupUrlRule([
            'prefix' => $this->id,
            'rules' => [
                '<controller:\w+>' => '<controller>/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                //'<action:\w+>' => 'default/<action>',

            ],
        ]);
        $app->getUrlManager()->addRules($groupUrlRule->rules, false);

        if (isset($config->api_token)) {
            $app->setComponents([
                'telegram' => [
                    'class' => 'shopium\mod\telegram\components\Telegram',
                    'botToken' => $config->api_token,
                ]
            ]);
        }
    }

    public function getAdminMenu()
    {
        return [
            'system' => [
                'items' => [
                    [
                        'label' => Yii::t('telegram/default', 'MODULE_NAME'),
                        'url' => ['/admin/telegram'],
                        'icon' => $this->icon,
                    ],
                ],
            ]
        ];
    }

    public function getInfo()
    {
        return [
            'label' => Yii::t('telegram/default', 'MODULE_NAME'),
            'author' => $this->author,
            'version' => '1.0',
            'icon' => $this->icon,
            'description' => Yii::t('telegram/default', 'MODULE_DESC'),
            'url' => ['/admin/telegram'],
        ];
    }

}
