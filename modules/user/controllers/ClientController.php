<?php

namespace app\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Social auth controller for User module
 */
class ClientController extends Controller
{

    public $layout = '@user/views/layouts/dashboard';
    public $icon, $dataModel, $pageName, $breadcrumbs;
    public $jsMessages = [];
    public $dashboard = false;
    public $enableStatistic=true;
    public $buttons=[];
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                      //  'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}
