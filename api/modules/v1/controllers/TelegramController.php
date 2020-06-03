<?php

namespace api\modules\v1\controllers;

use api\controllers\ApiController;
use api\modules\v1\models\cart\Order;
use app\modules\telegram\components\Api;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Entities\InputMedia\InputMediaPhoto;
use Longman\TelegramBot\Request;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\ServerErrorHttpException;

class TelegramController extends ApiController
{
    public $modelClass = Order::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['delete'], $actions['view'], $actions['create'], $actions['update']);
        return $actions;
    }

    public function actionSendMessages()
    {

        $telegram = new Api(Yii::$app->user->token);
        $params = Yii::$app->getRequest()->getBodyParams();
        $result['success'] = false;
        if (!isset($params['message'])) {
            $result['message'] = 'error required message';
        }

        $chats = \app\modules\telegram\models\Chat::find()->asArray()->all();
        if ($chats) {
            if (isset($params['action'])) {
                foreach ($params['action'] as $action) {
                    if (isset($action['text']) && isset($action['url'])) {
                        $inlineKeyboards[] = [
                            new InlineKeyboardButton(['text' => $action['text'], 'url' => $action['url']]),
                        ];
                        $data['reply_markup'] = new InlineKeyboard([
                            'inline_keyboard' => $inlineKeyboards
                        ]);
                    } else {
                        $result['message'] = 'Ошибка название кнопки или URL';
                        return $result;
                    }
                }

            }
            if (isset($params['disable_notification'])) {
                $data['disable_notification'] = $params['disable_notification'];
            }
            $data['text'] = $params['message'];
            $total = 0;
            foreach ($chats as $chat) {


                $data['chat_id'] = $chat['id'];

                $send = Request::sendMessage($data);
                $res = $send->getResult();
                if ($send->isOk()) {
                    $result['success'] = true;
                    $result['message'] = 'Сообщения успешно доставлено';

                } else {
                    $result['error'] = $send->getDescription();
                }
                $total++;
            }
            $result['total'] = $total;
        }

        return $result;
    }

    public function actionSendPhoto()
    {
        $telegram = new Api(Yii::$app->user->token);
        $params = Yii::$app->getRequest()->getBodyParams();
        $result['success'] = false;
        if (!isset($params['photo'])) {
            $result['message'] = 'error required photo';
        }

        $chats = \app\modules\telegram\models\Chat::find()->asArray()->all();
        if ($chats) {

            if (isset($params['caption'])) {
                $data['caption'] = $params['caption'];
            }
            if (isset($params['disable_notification'])) {
                $data['disable_notification'] = $params['disable_notification'];
            }
            $data['photo'] = $params['photo'];
            $total = 0;
            foreach ($chats as $chat) {
                $data['chat_id'] = $chat['id'];
                $send = Request::sendPhoto($data);
                $res = $send->getResult();
                if ($send->isOk()) {
                    $result['success'] = true;
                    $result['message'] = 'Фото успешно доставлено';

                } else {
                    $result['error'] = $send->getDescription();
                }
                $total++;
            }
            $result['total'] = $total;
        }

        return $result;
    }


    public function actionSendMediaGroup()
    {
        $telegram = new Api(Yii::$app->user->token);
        $params = Yii::$app->getRequest()->getBodyParams();
        $result['success'] = false;
        if (!isset($params['media'])) {
            $result['message'] = 'error required media';
        }

        $chats = \app\modules\telegram\models\Chat::find()->asArray()->all();
        if ($chats) {
            if (isset($params['disable_notification'])) {
                $data['disable_notification'] = $params['disable_notification'];
            }
            $medias = [];
            foreach ($params['media'] as $media) {
                $mediaData=[];
                $mediaData['type'] = 'photo';
                $mediaData['media'] = $media['url'];
                if (isset($media['caption'])) {
                    $mediaData['caption'] = $media['caption'];
                }
                $medias[] = new InputMediaPhoto($mediaData);
            }
            $data['media'] = $medias;
            $total = 0;
            foreach ($chats as $chat) {
                $data['chat_id'] = $chat['id'];
                $send = Request::sendMediaGroup($data);
                $res = $send->getResult();
                if ($send->isOk()) {
                    $result['success'] = true;
                    $result['message'] = 'Фото успешно доставлено';

                } else {
                    $result['error'] = $send->getDescription();
                }
                $total++;
            }
            $result['total'] = $total;
        }

        return $result;
    }
}


