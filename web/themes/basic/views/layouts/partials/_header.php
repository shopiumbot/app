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

<div class="loaderArea d-none">
    <div class="loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
    </div>
</div>


<div class="alert alert-info d-none" id="alert-demo" style="margin: 1rem">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h5 class="alert-heading">Добро пожаловать!</h5>
    Это демонстрационный сайт, вся информация на сайте вымышленная, предоставлена исключительно для ознакомление с
    функционало сайта.

</div>
<header>
    <div id="header-top">
        <div class="container">
            <nav class="navbar-expand">
                <div class="navbar-collapse">
                    <ul class="nav">
                        <li class="nav-item">
                            <?= Html::a(Yii::t('compare/default', 'Доставка'), ['/compare'], ['class' => 'nav-link']) ?>
                        </li>
                        <li class="nav-item">
                            <?= Html::a(Yii::t('compare/default', 'Возврат'), ['/compare'], ['class' => 'nav-link']) ?>
                        </li>

                        <script async src="https://telegram.org/js/telegram-widget.js?8" data-telegram-login="shopiumbot" data-size="large" data-auth-url="/test" data-request-access="write"></script>

                    </ul>
                    <ul class="nav ml-auto">

                        <?php if (count(Yii::$app->languageManager->getLanguages()) > 1) { ?>
                            <li class="dropdown">
                                <a href="#" class="nav-link dropdown-toggle"
                                   data-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false">
                                    <span class="d-none d-md-inline">Язык</span>
                                    <strong><?= Html::img('/uploads/language/' . Yii::$app->languageManager->active->flag_name, ['alt' => Yii::$app->languageManager->active->name]) ?></strong></a>
                                <div class="dropdown-menu">
                                    <?php

                                    foreach (Yii::$app->languageManager->getLanguages() as $lang) {

                                        $classLi = ($lang->code == Yii::$app->language) ? $lang->code . ' active' : $lang->code;
                                        $link = ($lang->is_default) ? CMS::currentUrl() : '/' . $lang->code . CMS::currentUrl();
                                        //Html::link(Html::image('/uploads/language/' . $lang->flag_name, $lang->name), $link, array('title' => $lang->name));

                                        echo Html::a(Html::img('/uploads/language/' . $lang->flag_name, ['alt' => $lang->name]) . ' ' . $lang->name, $link, ['class' => 'dropdown-item']);


                                    }
                                    ?>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (Yii::$app->user->isGuest) { ?>
                            <li class="nav-item">
                                <?= Html::a(Html::icon('user') . ' ' . Yii::t('user/default', 'LOGIN'), ['/user/login'], ['class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">
                                <?= Html::a(Yii::t('user/default', 'REGISTER'), ['/user/register'], ['class' => 'nav-link']); ?>
                            </li>
                        <?php } else { ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false"><?= Yii::$app->user->username; ?>
                                </a>
                                <div class="dropdown-menu">
                                    <?= Html::a(Html::icon('user') . ' ' . Yii::t('user/default', 'PROFILE'), ['/user/profile'], ['class' => 'dropdown-item']); ?>
                                     <?php
                                    if (Yii::$app->user->can('admin')) {
                                        echo '<div class="dropdown-divider"></div>';
                                        echo Html::a(Html::icon('tools') . ' ' . Yii::t('admin/default', 'MODULE_NAME'), ['/admin'], ['class' => 'dropdown-item']);
                                        echo '<div class="dropdown-divider"></div>';
                                    }
                                    ?>
                                    <?= Html::a(Html::icon('logout') . ' ' . Yii::t('user/default', 'LOGOUT'), ['/user/logout'], ['class' => 'dropdown-item']); ?>

                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>
        </div>

    </div>
    <div class="container" id="header-center">
        <div class="row">
            <div class="col-lg-3 col-md-6 d-flex align-items-center">
                <a class="navbar-brand ml-auto mr-auto mb-3 mb-md-0" href="/"></a>
            </div>
            <div class="col-lg-2 col-md-6 d-flex align-items-center">
                <div class="header-phones ml-auto mr-auto mb-3 mb-md-0">
                    <?php if (isset($config->phone)) { ?>
                        <?php foreach ($config->phone as $phone) { ?>
                            <?= Html::tel($phone['number'], ['class' => 'mb-2 mt-2 phone h5 ' . CMS::slug(CMS::phoneOperator($phone['number']))]); ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container megamenu">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
                    aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>
    </nav>

</header>
