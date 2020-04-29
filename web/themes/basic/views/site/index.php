<?php
use panix\engine\Html;
use panix\engine\CMS;
?>
    <div class="jumbotron">
        <div class="col-sm-8 mx-auto">
            <h1>Hi !</h1>

        </div>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="text-center"></th>
            <th class="text-center">Basic</th>
            <th class="text-center">Standard</th>
            <th class="text-center">Premium</th>
        </tr>
        <tr>
            <td class="text-center"></td>
            <td class="text-center">
                <div class="font-weight-bold">300 UAH</div>
                <span class="text-muted">мес.</span>
            </td>
            <td class="text-center">
                <div class="font-weight-bold">700 UAH</div>
                <span class="text-muted">мес.</span>
            </td>
            <td class="text-center">
                <div class="font-weight-bold">2 500 UAH</div>
                <span class="text-muted">мес.</span>
            </td>
        </tr>
        <tr>
            <td class="text-right">Количество товаров в каталоге</td>
            <td class="text-center">200</td>
            <td class="text-center">5000</td>
            <td class="text-center">&infin;</td>
        </tr>
        <tr>
            <td class="text-right">Фото у товаров</td>
            <td class="text-center">1</td>
            <td class="text-center">3</td>
            <td class="text-center">&infin;</td>
        </tr>
        <tr>
            <td class="text-right">Поддержка</td>
            <td class="text-center"><i class="icon-check text-success"></i></td>
            <td class="text-center"><i class="icon-check text-success"></i></td>
            <td class="text-center"><i class="icon-check text-success"></i></td>
        </tr>
        <tr>
            <td class="text-right">Скидки на группы и бренды товаров</td>
            <td class="text-center"><i class="icon-delete text-danger"></i></td>
            <td class="text-center"><i class="icon-check text-success"></i></td>
            <td class="text-center"><i class="icon-check text-success"></i></td>
        </tr>
        <tr>
            <td class="text-right">Отключение подписи</td>
            <td class="text-center"><i class="icon-delete text-danger"></i></td>
            <td class="text-center"><i class="icon-check text-success"></i></td>
            <td class="text-center"><i class="icon-check text-success"></i></td>
        </tr>
        <tr>
            <td class="text-right">Доступ к API
                <a href="#" title="Доступ к API" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Позволяет многое ;)">
                    <i class="icon-info text-primary"></i>
                </a>
            </td>
            <td class="text-center"><i class="icon-delete text-danger"></i></td>
            <td class="text-center"><i class="icon-check text-success"></i></td>
            <td class="text-center"><i class="icon-check text-success"></i></td>
        </tr>
        <tr>
            <td class="text-right">Прием платежей</td>
            <td class="text-center"><i class="icon-delete text-danger"></i></td>
            <td class="text-center"><i class="icon-delete text-danger"></i></td>
            <td class="text-center"><i class="icon-check text-success"></i></td>
        </tr>


        <tr>
            <td class="text-right"></td>
            <td class="text-center"><?= Html::a('Регистрация', ['/user/register','plan'=>1], ['class' => 'btn btn-outline-success']); ?></td>
            <td class="text-center"><?= Html::a('Регистрация', ['/user/register','plan'=>2], ['class' => 'btn btn-outline-success']); ?></td>
            <td class="text-center"><?= Html::a('Регистрация', ['/user/register','plan'=>3], ['class' => 'btn btn-outline-success']); ?></td>
        </tr>
    </table>

<?php

if(false){
$data = [
    'class' => 'hosting_site',
    'method' => 'host_create',
    'site' => 'shopiumbot.com',
    'subdomain' => 'test2',
];
$createDomain = Yii::$app->getModule('user')->hostingApi($data);
if ($createDomain['status'] == 'success') {


    $ssldata = [
        'class' => 'hosting_site_config_ssl',
        'method' => 'crt_lets_encrypt',
        'host' => $data['subdomain'].'.'.$data['site'],

    ];
    $setSSL = Yii::$app->getModule('user')->hostingApi($ssldata);
    if ($setSSL['status'] == 'success') {
        CMS::dump($setSSL);
    }


    $phpdata = [
        'class' => 'hosting_site_config_php',
        'method' => 'edit',
        'host' => $data['subdomain'].'.'.$data['site'],
        'php_version'=>'php73'

    ];
    $editPHP = Yii::$app->getModule('user')->hostingApi($phpdata);
    if ($editPHP['status'] == 'success') {
        CMS::dump($editPHP);
    }

    $config_ws = [
        'class' => 'hosting_site_config_ws',
        'method' => 'edit',
        'host' => $data['subdomain'].'.'.$data['site'],
        'https_redirect' => 'to_https',
        'redirect' => 'www_from'

    ];
    $response_config_ws = Yii::$app->getModule('user')->hostingApi($config_ws);
    if ($response_config_ws['status'] == 'success') {
        CMS::dump($response_config_ws);
    }


    print_r($createDomain);

} else {
    echo print_r($createDomain['message']);
}
    /*
    $data = [
        'class' => 'hosting_database',
        'method' => 'database_create',
        'name' => 'botc2',
        'collation' => 'utf8_general_ci',
        'user_create' => true,
    ];
    $createDb = Yii::$app->getModule('user')->hostingApi($data);
    if ($createDb['status'] == 'success') {
        if ($createDb['data']['user']['status'] == 'success') {
            print_r($createDb['data']['user']['login']);
            print_r($createDb['data']['user']['password']);
        }
    } else {
        echo print_r($createDb['message']);
    }*/
}



