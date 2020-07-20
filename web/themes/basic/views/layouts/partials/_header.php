<?php
use panix\engine\Html;
use yii\helpers\Url;
use panix\engine\CMS;
use app\modules\shop\models\Category;

$this->registerJs("
    $(window).on('load', function () {
        var preloader = $('.loaderArea'),
            loader = preloader.find('.loader');
        loader.fadeOut();
        preloader.delay(350).fadeOut('slow');
    });

", \yii\web\View::POS_END, 'preloader-js');

$config = Yii::$app->settings->get('contacts');

?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07"
                aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#plans">Тарифы и цены</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#capability">Возможности</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contacts">Контакты</a>
                </li>
            </ul>
            <div class="my-2 my-md-0">
                <?php if (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '178.212.194.135'])) { ?>
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <a class="nav-link float-left" href="/user/login"><i class="icon-user-outline"></i> войти</a>
                        <?= Html::a('Регистрация',['/user/default/register'],['class'=>'btn btn-warning']); ?>
                    <?php } else { ?>
                        <?= Html::a('профиль',['/user/default/profile'],['class'=>'btn btn-success']); ?>
                        <?= Html::a('Выход',['/user/default/logout'],['class'=>'btn btn-link']); ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

    </div>
</nav>
