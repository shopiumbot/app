<?php

use panix\engine\Html;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 */

\app\web\themes\basic\ThemeAsset::register($this);

/*$c = Yii::$app->settings->get('shop');


$this->registerJs("
        var price_penny = " . $c->price_penny . ";
        var price_thousand = " . $c->price_thousand . ";
        var price_decimal = " . $c->price_decimal . ";
     ", yii\web\View::POS_HEAD, 'numberformat');*/

//add
//Yii::$app->authManager->assign(Yii::$app->authManager->createRole('Manager'),2);

//remove
//Yii::$app->authManager->revoke(Yii::$app->authManager->createRole('Manager'),2);

$this->registerMetaTag([
    'property' => 'og:url',
    'content' => $this->context->assetUrl . '/images/og-logo.jpg'
]);
$this->registerMetaTag([
    'name'=>'description',
    'content'=>'Заказать Shopium Bot для магазина в Telegram. ✔️ Продающий чат-бот для любого бизнеса. ⏩ От 300 грн в месяц. ☎ +38(063) 489-26-95'
]);
$this->title = 'Заказать магазин в Телеграм, чат-бот Telegram для интернет-магазина, цена'

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KK4SZVC');</script>
    <!-- End Google Tag Manager -->


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-66266137-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-66266137-2');
    </script>

</head>
<body class="d-flex flex-column h-100">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KK4SZVC"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<?php $this->beginBody() ?>
<?= $this->render('partials/_header'); ?>
<main role="main" class="flex-shrink-0">

    <div class="jumbotron pt-md-4 pb-md-4 pl-0 pr-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-7 d-flex align-items-center">
                    <div style="position: relative;z-index: 10">
                        <div class="text-gradient"><h1>Shopium Bot для магазина в Telegram</h1></div>
                        <div class="mr-0 mr-lg-5">
                        <p>Данный бот позволяет создать собственный магазин в месенджере Telegram. Решение будет интересно как
                            для клиентов не имеющих собственного интернет-магазина также для тех, у кого он имеется, для этого
                            существует API, что очень упростит взаимодействия между интернет-магазином и телеграм-магазином.
                        <p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4 offset-lg-1 text-center">
                    <div class="bot-phone m-auto">
                        <!--  poster="<?= $this->context->assetUrl; ?>/images/phone.png" -->
                        <video width="252" autoplay="" loop="" muted="" playsinline="">
                            <source src="<?= $this->context->assetUrl; ?>/bot.webm" type="video/webm">
                            <source src="<?= $this->context->assetUrl; ?>/bot.mp4" type="video/mp4">
                            <source src="<?= $this->context->assetUrl; ?>/bot.ogv" type="video/ogg">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($this->context->breadcrumbs)) {
        echo Breadcrumbs::widget([
            'links' => $this->context->breadcrumbs,
        ]);
    }
    ?>


    <?= $content ?>


</main>


<?= $this->render('partials/_footer'); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
