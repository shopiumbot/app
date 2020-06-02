<?php

namespace api\controllers;

use Yii;
use app\modules\user\models\User;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\rest\Serializer;
use yii\web\Response;


class ApiController extends ActiveController
{

    public $serializer = [
        'class' => \api\rest\Serializer::class,
    ];

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
    }

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
            /*'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBasicAuth::class,
                    HttpBearerAuth::class,
                    QueryParamAuth::class,
                ],
            ],*/
           /* 'authenticator222' => [
                'class' => HttpBasicAuth::class,
                'auth' => function ($username, $password) {

                    $user = User::find()->where(['username' => $username, 'password' => $password])->one();
                    if ($user->verifyPassword($password)) {
                        return $user;
                    }
                },
            ],*/
            'authenticator' => [
                'class' => QueryParamAuth::class,
                'tokenParam' => 'token',

            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                    'allow' => true,
                    'roles' => ['@']
                    ]
                ],
            ]
        ];
    }



}


