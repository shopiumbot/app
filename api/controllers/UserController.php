<?php

namespace api\controllers;

use panix\mod\user\models\User;
use yii\rest\ActiveController;


class UserController extends ActiveController
{
    public $modelClass = User::class;
}


