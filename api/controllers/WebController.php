<?php

namespace api\controllers;

use panix\engine\CMS;
use Yii;
use yii\rest\Controller;

class WebController extends Controller
{

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
            return $this->asJson([
                'exception' => $exception,
                'handler' => $handler,
                'statusCode' => $statusCode,
                'name' => $name,
                'message' => $message
            ]);
        }
    }
}


