<?php

namespace api\controllers;

use panix\engine\CMS;
use Yii;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

class WebController extends Controller
{

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => 'format',
                'formats' => [

                    'xml' => Response::FORMAT_XML,
                    'json' => Response::FORMAT_JSON,
                ]
            ],
        ];
    }

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionError()
    {
        $handler = Yii::$app->errorHandler;
        $exception = $handler->exception;


        // CMS::dump(Yii::$app);die;


        if ($exception !== null) {
            $statusCode = $exception->statusCode;
            $name = $exception->getName();
            $message = $exception->getMessage();
            return [
                //'exception' => $exception,
                //'handler' => $handler,
                'statusCode' => $statusCode,
                'name' => $name,
                'message' => $message
            ];
        }
    }
}


