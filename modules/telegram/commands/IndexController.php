<?php

namespace app\modules\telegram\commands;

use yii\console\Controller;
use Yii;
use app\modules\telegram\components\Api;

class IndexController extends Controller
{
    public function beforeAction2($action)
    {
        $langManager = Yii::$app->languageManager;
        Yii::$app->language = (isset($langManager->default->code)) ? $langManager->default->code : Yii::$app->language;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionClean($keep = 7)
    {
        $db = \Yii::$app->db;
        $db->createCommand()->delete('{{%tlgrm_messages}}', 'time < \'' . date("Y-m-d H:i:s", time() - (3600 * 24 * $keep)) . '\'')->execute();
    }


    public function actionIndex()
    {

        $commands_paths = [

            __DIR__ . '/AdminCommands',
            __DIR__ . '/SystemCommands',
            __DIR__ . '/UserCommands',

        ];

        $mysql_credentials = [
            'host' => Yii::$app->getModule('telegram')->getDsnAttribute('host'),
            'user' => Yii::$app->db->username,
            'password' => Yii::$app->db->password,
            'database' =>Yii::$app->getModule('telegram')->getDsnAttribute('dbname'),
        ];
        try {

            $telegram = new Api('1268221529:AAGtVcw8e8jJdC8ir-GFDlQVobxhYWDy92s','shopium');

            // Add commands paths containing your custom commands
            $telegram->addCommandsPaths($commands_paths);

            // Enable admin users
         //   $telegram->enableAdmins();


            // Enable MySQL
            //$telegram->enableExternalMySql(Yii::$app->db->pdo);
            $telegram->enableMySql($mysql_credentials, Yii::$app->db->tablePrefix.'telegram__');



            // Set custom Upload and Download paths
            //$telegram->setDownloadPath(Yii::getAlias('@app/web/downloads/telegram'));
            //$telegram->setUploadPath(Yii::getAlias('@app/web/uploads/telegram'));
            $i=1;
            while (true) {

                sleep(2);
                // Create Telegram API object

                //$telegram->setCommandConfig('weather', [
                //    'owm_api_key' => '41b3ffa90fad3fb24efcd8f32c6102fa',
               // ]);

                // Here you can set some command specific parameters
                // e.g. Google geocode/timezone api key for /date command
               // $telegram->setCommandConfig('date', ['google_api_key' => 'your_google_api_key_here']);

                // Requests Limiter (tries to prevent reaching Telegram API limits)
                $telegram->enableLimiter();

                // Handle telegram getUpdates request
                $server_response = $telegram->handleGetUpdates();
               // $telegram->useGetUpdatesWithoutDatabase(true);
               // print_r($server_response);die;
                if ($server_response->isOk()) {
                    $update_count = count($server_response->getResult());
                    echo $i.': '.date('Y-m-d H:i:s', time()) . ' - Processed ' . $update_count . ' updates' . PHP_EOL;
                } else {
                    echo $i.': '.date('Y-m-d H:i:s', time()) . ' - Failed to fetch updates' . PHP_EOL;
                    echo $server_response->printError();
                }
                $i++;
            }
        } catch (\Longman\TelegramBot\Exception\TelegramException $e) { //\Longman\TelegramBot\Exception\TelegramException
            echo 'TelegramException: '.$e->getMessage();
            // Log telegram errors
            //Yii::error($e->getMessage(),'telegram');
            \Longman\TelegramBot\TelegramLog::error($e);
        } catch
        (\Longman\TelegramBot\Exception\TelegramLogException $e) {
            // Catch log initialisation errors
            echo 'TelegramLogException: '.$e->getMessage();
        }

    }
}
