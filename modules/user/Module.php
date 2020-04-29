<?php

namespace app\modules\user;

use app\modules\user\models\User;
use yii\console\Application;
use yii\db\Exception;
use yii\httpclient\Client;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\web\GroupUrlRule;
use panix\engine\WebModule;
use app\modules\user\models\forms\SettingsForm;
use panix\mod\admin\widgets\sidebar\BackendNav;

/**
 * Class Module
 * @package app\modules\user
 *
 * @property array|string|null $loginRedirect
 */
class Module extends WebModule implements BootstrapInterface
{
    public $icon = 'users';
    /**
     * @var string Alias for module
     */

    /**
     * @var bool If true, users are required to enter an email
     */
    public $requireEmail = true;

    /**
     * @var bool If true, users are required to enter a username
     */
    public $requireUsername = false;

    /**
     * @var bool If true, users can enter an email. This is automatically set to true if $requireEmail = true
     */
    public $useEmail = true;

    /**
     * @var bool If true, users can enter a username. This is automatically set to true if $requireUsername = true
     */
    public $useUsername = true;

    /**
     * @var bool If true, users can log in using their email
     */
    public $loginEmail = true;

    /**
     * @var bool If true, users can log in using their username
     */
    public $loginUsername = true;

    /**
     * @var array|string|null Url to redirect to after logging in. If null, will redirect to home page. Note that
     * AccessControl takes precedence over this (see [[yii\web\User::loginRequired()]])
     */
    public $loginRedirect = null;

    /**
     * @var array|string|null Url to redirect to after logging out. If null, will redirect to home page
     */
    public $logoutRedirect = null;

    /**
     * @var bool If true, users will have to confirm their email address after registering (= email activation)
     */
    public $emailConfirmation = true;

    /**
     * @var bool If true, users will have to confirm their email address after changing it on the account page
     */
    public $emailChangeConfirmation = true;

    /**
     * @var string Time before userKeys expire (currently only used for password resets)
     */
    public $resetKeyExpiration = "48 hours";

    /**
     * @var string Email view path
     */
    public $emailViewPath = "@user/mail";

    public function hostingApi(array $data = [])
    {

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://adm.tools/api.php')
            ->setData(\yii\helpers\ArrayHelper::merge([
                'auth_login' => 'andrew.panix@gmail.com',
                'auth_token' => '4abtu62s4kdk646ed99437ld3dd3ub9dbdc47v8s7jvpvk4qm4yr8sat9xprb36w',
                'account' => 'corner'
            ], $data))
            ->send();
        if ($response->isOk) {
            return $response->data;
        }
        return false;
    }

    public function getAdminMenu()
    {
        return [
            'user' => [
                'label' => Yii::t('user/default', 'MODULE_NAME'),
                'icon' => $this->icon,
                'items' => [
                    [
                        'label' => Yii::t('user/default', 'MODULE_NAME'),
                        "url" => ['/admin/user'],
                        'icon' => $this->icon
                    ],
                    [
                        'label' => Yii::t('app/default', 'SETTINGS'),
                        "url" => ['/admin/user/settings'],
                        'icon' => 'settings'
                    ]
                ],
            ],
        ];
    }

    public function getAdminSidebar()
    {
        return (new BackendNav())->findMenu($this->id)['items'];
    }

    /**
     * Установка модуля
     * @return boolean
     */
    public function afterInstall()
    {
        Yii::$app->db->import($this->id);

        if (Yii::$app->settings)
            Yii::$app->settings->set($this->id, SettingsForm::defaultSettings());
        return parent::afterInstall();
    }

    /**
     * Удаление модуля
     * @return boolean
     */
    public function afterUninstall()
    {

        Yii::$app->settings->clear($this->id);
        return parent::afterUninstall();
    }

    public function getInfo()
    {
        return [
            'label' => Yii::t('user/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => 'icon-users',
            'description' => Yii::t('user/default', 'MODULE_DESC'),
            'url' => ['/admin/user'],
        ];
    }

    /**
     * Check for valid email/username properties
     */
    protected function checkModuleProperties()
    {
        // set use fields based on required fields
        if ($this->requireEmail) {
            $this->useEmail = true;
        }
        if ($this->requireUsername) {
            $this->useUsername = true;
        }

        // get class name for error messages
        $className = get_called_class();

        // check required fields
        if (!$this->requireEmail && !$this->requireUsername) {
            throw new InvalidConfigException("{$className}: \$requireEmail and/or \$requireUsername must be true");
        }
        // check login fields
        if (!$this->loginEmail && !$this->loginUsername) {
            throw new InvalidConfigException("{$className}: \$loginEmail and/or \$loginUsername must be true");
        }
        // check email fields with emailConfirmation/emailChangeConfirmation is true
        if (!$this->useEmail && ($this->emailConfirmation || $this->emailChangeConfirmation)) {
            $msg = "{$className}: \$useEmail must be true if \$email(Change)Confirmation is true";
            throw new InvalidConfigException($msg);
        }

        // ensure that the "user" component is set properly
        // this typically causes problems in the yii2-advanced app
        // when people set it in "common/config" instead of "frontend/config" and/or "backend/config"
        //   -> this results in users failing to login without any feedback/error message
        if (!Yii::$app->request->isConsoleRequest && !Yii::$app->get("user") instanceof \app\modules\user\components\WebUser) {
            throw new InvalidConfigException('Yii::$app->user is not set properly. It needs to extend \panix\user\components\User');
        }
    }

    public function getDefaultModelClasses()
    {
        return [
            'User' => 'app\modules\user\models\User',
            'ResendForm' => 'app\modules\user\models\forms\ResendForm',
            'UserKey' => 'app\modules\user\models\UserKey',
        ];
    }

    public function getDb()
    {
        if (!(Yii::$app instanceof Application)) {
            if (Yii::$app->user->isGuest) {
                return Yii::$app->cache->getOrSet(__CLASS__, function () {
                    $user = User::findByHook(Yii::$app->request->get('webhook'));
                    if ($user) {
                        return $user->getClientDb();
                    } else {
                        throw new Exception('error client db in module');
                    }
                });
            } else {
                return Yii::$app->user->getClientDb();
            }
        }
    }

    /**
     * @inheritdoc
     * NOTE: THIS IS NOT CURRENTLY USED.
     *       This is here for future versions and will need to be bootstrapped via config file
     *
     */
    public function bootstrap($app)
    {

        // add rules for admin/copy/auth controllers
        $groupUrlRule = new GroupUrlRule([
            'prefix' => $this->id,
            'rules' => [
                '<controller:(profile)>' => '<controller>/index',
                '<controller:(webhook)>/<webhook:[0-9a-zA-Z\-\_]+>' => '<controller>/index',
                '<controller:(admin|copy|auth)>' => '<controller>',
                '<controller:(admin|copy|auth)>/<action:\w+>' => '<controller>/<action>',
                '<action:\w+>/authclient/<authclient:[0-9a-zA-Z\-]+>' => 'default/<action>',
                'register/plan/<plan:[0-9]+>' => 'default/<action>',
                '<action:\w+>' => 'default/<action>',

            ],
        ]);
        if (!(Yii::$app instanceof \yii\console\Application)) {
            if (!Yii::$app->user->isGuest) {

                $app->setComponents([
                    'clientDb' => [
                        'class' => 'yii\db\Connection',
                        'dsn' => 'mysql:host=corner.mysql.tools;dbname=' . Yii::$app->user->db_name,
                        'username' => Yii::$app->user->db_user,
                        'password' => Yii::$app->user->db_password,
                        'charset' => 'utf8',
                        'tablePrefix' => 'client_',
                        'serverStatusCache' => YII_DEBUG ? 0 : 3600,
                        'schemaCacheDuration' => YII_DEBUG ? 0 : 3600 * 24,
                        'queryCacheDuration' => YII_DEBUG ? 0 : 3600 * 24 * 7,
                        'enableSchemaCache' => true,
                        'schemaCache' => 'cache'
                    ]
                ]);
            }
        }
        $app->getUrlManager()->addRules($groupUrlRule->rules, false);
        if (!(Yii::$app instanceof \yii\console\Application)) {
            $config = $app->settings->get($this->id);
            $authClientCollection = [];

            if (!empty($config->oauth_google_id) && !empty($config->oauth_google_secret))
                $authClientCollection['clients']['google'] = [
                    'class' => 'panix\engine\authclient\clients\Google',
                ];

            if (!empty($config->oauth_facebook_id) && !empty($config->oauth_facebook_secret))
                $authClientCollection['clients']['facebook'] = [
                    'class' => 'panix\engine\authclient\clients\Facebook',
                ];

            if (!empty($config->oauth_vkontakte_id) && !empty($config->oauth_vkontakte_secret))
                $authClientCollection['clients']['vkontakte'] = [
                    'class' => 'panix\engine\authclient\clients\VKontakte',
                ];

            if (!empty($config->oauth_yandex_id) && !empty($config->oauth_yandex_secret))
                $authClientCollection['clients']['yandex'] = [
                    'class' => 'panix\engine\authclient\clients\Yandex',
                ];

            if (!empty($config->oauth_github_id) && !empty($config->oauth_github_secret))
                $authClientCollection['clients']['github'] = [
                    'class' => 'panix\engine\authclient\clients\Github',
                ];

            if (!empty($config->oauth_linkedin_id) && !empty($config->oauth_linkedin_secret))
                $authClientCollection['clients']['linkedin'] = [
                    'class' => 'panix\engine\authclient\clients\LinkedIn',
                ];

            if (!empty($config->oauth_live_id) && !empty($config->oauth_live_secret))
                $authClientCollection['clients']['live'] = [
                    'class' => 'panix\engine\authclient\clients\Live',
                ];


            if (!empty($config->oauth_twitter_id) && !empty($config->oauth_twitter_secret))
                $authClientCollection['clients']['twitter'] = [
                    'class' => 'panix\engine\authclient\clients\TwitterOAuth2',
                    // for Oauth v1
                    /*'attributeParams' => [
                        'include_email' => 'true'
                    ]*/
                ];

            if (isset($authClientCollection['clients']) && count($authClientCollection['clients'])) {
                $app->setComponents([
                    'authClientCollection' => [
                        'class' => 'yii\authclient\Collection',
                        'clients' => $authClientCollection['clients'],
                    ],
                ]);
            }
        }
    }

}
