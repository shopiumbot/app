<?php

namespace api\controllers;

use app\modules\user\models\User;
use yii\rest\ActiveController;


class UserController extends ApiController
{
    public $modelClass = User::class;
}


