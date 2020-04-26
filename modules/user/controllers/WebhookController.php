<?php

namespace app\modules\user\controllers;

use app\modules\user\models\User;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use Yii;
use yii\filters\VerbFilter;
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
        $data = json_encode($data,true);
        file_put_contents(__DIR__.'/log2.txt',$data);
        Yii::info('run hoook');
        die;
    }
    public function actionIndex($hook)
    {


        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findByHook($hook);
        if ($user) {
            $mysql_credentials = [
                'host' => 'corner.mysql.tools',
                'user' => $user->db_user,
                'password' => $user->db_password,
                'database' => $user->db_name,
            ];

            try {
                // Create Telegram API object
                //$telegram = new Api($user->token, 'test');
                $telegram = new Telegram($user->token, 'shopiumbot');
                $basePath = \Yii::$app->getModule('telegram')->basePath;
                $commands_paths = [
                    realpath($basePath . '/commands') . '/SystemCommands',
                    realpath($basePath . '/commands') . '/AdminCommands',
                    realpath($basePath . '/commands') . '/UserCommands',
                ];
                $telegram->enableMySql($mysql_credentials, '64Tv_telegram__');
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
