<?php

namespace app\modules\user\controllers;

use app\modules\telegram\components\Api;
use app\modules\user\models\User;
use Longman\TelegramBot\Exception\TelegramException;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for User module
 */
class WebhookController extends Controller
{

    public function behaviors2()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    //'index' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        //if ($action->id == 'index') {
        $this->enableCsrfValidation = false;

        // }
        return parent::beforeAction($action);
    }

    public function actionIndex2()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = file_get_contents('php://input');
        $data = json_encode($data, true);
        file_put_contents(__DIR__ . '/log2.txt', $data);
        Yii::info('run hoook');
        die;
    }

    public function actionIndex($webhook)
    {


        /* $configCache = [
             'class' => 'yii\caching\FileCache',
             'directoryLevel' => 0,
             'keyPrefix' => '',
             'cachePath' => '@runtime/cache/' . $webhook
         ];

         $cache = Yii::createObject($configCache);*/


        Yii::$app->response->format = Response::FORMAT_JSON;


        if ($webhook) {
            $user = User::findByHook($webhook);

            //$user = Yii::$app->user->getClientDb();

            if ($user) {
                Yii::info('hook: ' . Yii::$app->request->get('webhook'));
                Yii::$app->setComponents([
                    'clientDb' => [
                        'class' => 'yii\db\Connection',
                        'dsn' => 'mysql:host=' . $user->db_host . ';dbname=' . $user->db_name,
                        'username' => $user->db_user,
                        'password' => $user->db_password,
                        'charset' => 'utf8',
                        'tablePrefix' => 'client_',
                        'serverStatusCache' => YII_DEBUG ? 0 : 3600,
                        'schemaCacheDuration' => YII_DEBUG ? 0 : 3600 * 24,
                        'queryCacheDuration' => YII_DEBUG ? 0 : 3600 * 24 * 7,
                        'enableSchemaCache' => true,
                        'schemaCache' => 'cache'
                    ]
                ]);
            } else {
                die('die 1');
            }
        } else {
            die('die 2');
        }
        $admins=ArrayHelper::merge([
            812367093 //all bots admin PANIX
        ],[]);

        if ($user) {
            $mysql_credentials = [
                'host' => $user->db_host,
                'user' => $user->db_user,
                'password' => $user->db_password,
                'database' => $user->db_name,
            ];

            try {
                // Create Telegram API object
                //$telegram = new Api($user->token, 'test');
                $telegram = new Api($user->token,'shopiumbot');
                //$telegram->db = $user->getClientDb();

                //  Yii::$app->getModule('telegram')->setApi($user->getClientDb());

                $telegram->enableAdmins($admins);
                $basePath = \Yii::$app->getModule('telegram')->basePath;
                $commands_paths = [
                    realpath($basePath . '/commands') . '/SystemCommands',
                    realpath($basePath . '/commands') . '/AdminCommands',
                    realpath($basePath . '/commands') . '/UserCommands',
                ];
                $telegram->enableMySql($mysql_credentials, 'client_telegram__');
                $telegram->addCommandsPaths($commands_paths);
                // Handle telegram webhook request
                $telegram->handle();
            } catch (TelegramException $e) {

                // Silence is golden!
                // log telegram errors
                Yii::error($e->getMessage());
                return $e->getMessage();
            }
            return null;

        } else {
            Yii::info('no find user by token');
        }

    }

}
