<?php
use panix\engine\Html;
use panix\engine\CMS;
use yii\widgets\ActiveForm;
use Longman\TelegramBot\Request;

$popClass = ' bg-warning2';
?>
<section id="plans">
    <div class="container">

        <div class="text-center">
            <div class="text-center mb-5">
                <h2>Тарифы и цены</h2>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered2">
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">Basic</th>
                    <th class="text-center <?= $popClass; ?>">Standard</th>
                    <th class="text-center">Standard +</th>
                    <th class="text-center">Premium</th>
                </tr>
                <tr>
                    <td class="text-right h6">Оплата помесячно</td>
                    <td class="text-center">
                        <div><strong>300</strong> <span class="text-muted">грн./мес.</span></div>
                        <small class="text-muted"></small>
                    </td>
                    <td class="text-center <?= $popClass; ?>">
                        <div><strong>700</strong> <span class="text-muted">грн./мес.</span></div>
                        <small class="text-muted"></small>
                    </td>
                    <td class="text-center">
                        <div><strong>900</strong> <span class="text-muted">грн./мес.</span></div>
                        <small class="text-muted"></small>
                    </td>
                    <td class="text-center">
                        <div><span class="text-muted">договорная</span></div>
                    </td>
                </tr>
                <tr>
                    <td class="text-right h6">Оплата за год</td>
                    <td class="text-center">
                        <div><strong>270</strong> <span class="text-muted">грн./мес.</span></div>
                        <small class="text-muted">(экономия 360 грн.)</small>
                    </td>
                    <td class="text-center <?= $popClass; ?>">
                        <div><strong>660</strong> <span class="text-muted">грн./мес.</span></div>
                        <small class="text-muted">(экономия 480 грн.)</small>
                    </td>
                    <td class="text-center">
                        <div><strong>850</strong> <span class="text-muted">грн./мес.</span></div>
                        <small class="text-muted">(экономия 600 грн.)</small>
                    </td>
                    <td class="text-center">
                        <div><span class="text-muted">договорная</span></div>
                    </td>
                </tr>

                <tr>
                    <td class="text-right h6">Количество товаров в каталоге</td>
                    <td class="text-center">200</td>
                    <td class="text-center <?= $popClass; ?>">5,000</td>
                    <td class="text-center">10,000</td>
                    <td class="text-center">&infin;</td>
                </tr>
                <tr>
                    <td class="text-right h6">Фото у товаров</td>
                    <td class="text-center">1</td>
                    <td class="text-center <?= $popClass; ?>">3</td>
                    <td class="text-center">3</td>
                    <td class="text-center">&infin;</td>
                </tr>
                <tr>
                    <td class="text-right h6">Поддержка</td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                    <td class="text-center <?= $popClass; ?>"><i class="icon-check text-success"></i></td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                </tr>
                <tr>
                    <td class="text-right h6">Скидки на группы и бренды товаров</td>
                    <td class="text-center"><i class="icon-delete text-danger"></i></td>
                    <td class="text-center <?= $popClass; ?>"><i class="icon-check text-success"></i></td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                </tr>
                <tr>
                    <td class="text-right h6">Отключение подписи</td>
                    <td class="text-center"><i class="icon-delete text-danger"></i></td>
                    <td class="text-center <?= $popClass; ?>"><i class="icon-check text-success"></i></td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                </tr>
                <tr>
                    <td class="text-right h6">Доступ к API
                        <a href="#" title="Доступ к API" data-container="body" data-trigger="hover"
                           data-toggle="popover" data-placement="top"
                           data-content="API позволит интегрировать чат-бота с вашей CRM или сайтом.">
                            <i class="icon-info text-primary"></i>
                        </a>
                    </td>
                    <td class="text-center"><i class="icon-delete text-danger"></i></td>
                    <td class="text-center <?= $popClass; ?>"><i class="icon-check text-success"></i></td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                </tr>
                <tr>
                    <td class="text-right h6">Прием платежей</td>
                    <td class="text-center"><i class="icon-delete text-danger"></i></td>
                    <td class="text-center <?= $popClass; ?>"><i class="icon-check text-success"></i></td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                    <td class="text-center"><i class="icon-check text-success"></i></td>
                </tr>


                <tr class="d-none">
                    <td class="text-right"></td>
                    <td class="text-center"><?= Html::a('Регистрация', ['/user/register', 'plan' => 1], ['class' => 'btn btn-outline-success']); ?></td>
                    <td class="text-center <?= $popClass; ?>"><?= Html::a('Регистрация', ['/user/register', 'plan' => 2], ['class' => 'btn btn-outline-success']); ?></td>
                    <td class="text-center"><?= Html::a('Регистрация', ['/user/register', 'plan' => 3], ['class' => 'btn btn-outline-success']); ?></td>
                </tr>
            </table>
        </div>
    </div>
</section>
<section id="bot-biz">
    <div class="container pt-5 pb-5">
        <div class="text-center">
            <div class="text-center mb-5 mt-5"><h2>Чат‑боты для бизнеса</h2></div>
        </div>
        <div class="row">
            <?php

            $list = [
                [
                    'name' => 'Действуйте на территории клиентов',
                    'icon' => 'mobile'
                ],
                [
                    'name' => 'Продажи по всем канонам',
                    'icon' => 'cart'
                ],
                [
                    'name' => 'Без рисков для бизнеса',
                    'icon' => 'hand-up'
                ],
                [
                    'name' => 'Поддержка',
                    'icon' => 'operator'
                ],
                [
                    'name' => 'Мы постоянно развиваем и улучшаем чат-бота',
                    'icon' => 'star-outline'
                ],
                [
                    'name' => 'С большими возможностями',
                    'icon' => 'tools'
                ],
                [
                    'name' => 'Без разработки',
                    'icon' => 'telegram-outline'
                ],
                [
                    'name' => 'Запуск до 15 минут',
                    'icon' => 'speedometer'
                ],
            ]
            ?>
            <?php foreach ($list as $item) { ?>
                <div class="col-lg-3 text-center mb-3 mt-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-dark p-3 radius" style="height:170px;width: 100%;display: grid">
                            <div class="text-white" style="font-size: 44px;">
                                <i class="icon-<?= $item['icon']; ?>"></i>
                            </div>
                            <p class="mt-2 mb-0 text-white"><?= $item['name']; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>
<section id="clients">
    <div class=" bg-light pt-5 pb-5">
        <div class="text-center"><h2>Наши клиенты</h2></div>
        <?php

        use panix\ext\owlcarousel\OwlCarouselWidget;

        OwlCarouselWidget::begin([
            'containerTag' => 'div',
            'containerOptions' => [
                'class' => 'container-class mt-5'
            ],
            'options' => [
                'navText' => [Html::icon('arrow-left'), Html::icon('arrow-right')],
                'autoplay' => true,
                'autoplayTimeout' => 5000,
                'items' => 3,
                'loop' => false,
                'responsiveClass' => true,
                'responsive' => [
                    0 => [
                        'items' => 1,
                        'nav' => false,
                        'dots' => true,
                        'center' => true,
                    ],
                    426 => [
                        'items' => 2,
                        'nav' => false,
                        'dots' => true,
                    ],
                    768 => [
                        'items' => 2,
                        'nav' => false
                    ],
                    1024 => [
                        'items' => 5,
                        'nav' => true,
                        'dots' => false
                    ]
                ]
            ]
        ]);

        $clients2 = \panix\mod\user\models\User::find()->where(['show_in_main' => 1])->all();

        ?>
        <?php foreach ($clients2 as $client) {

            $image = '/uploads/no-image.jpg';
            $api = new \panix\mod\telegram\components\Api($client->token, 'bot');

            $me = Request::getMe();
            //  CMS::dump($me->getResult()->username);die;
            try {

                $profile = Request::getUserProfilePhotos(['user_id' => $api->getBotId()]);

                if ($profile->isOk()) {
                    if ($profile->getResult()->photos) {
                        $photo = $profile->getResult()->photos[0][2];
                        $file = Request::getFile(['file_id' => $photo['file_id']]);
                        if (!file_exists(Yii::getAlias('@app/web/downloads/telegram') . DIRECTORY_SEPARATOR . $file->getResult()->file_path)) {
                            $download = Request::downloadFile($file->getResult());
                        }
                        $image = '/downloads/telegram/' . $file->getResult()->file_path;
                    }
                    //} else {
                    //  $image ='/uploads/no-image.jpg';
                }
            } catch (Exception $e) {

            }


            ?>
            <div class="item-class text-center ml-3 mr-3 ml-lg-4 mr-lg-4">
                <div class="mb-3">
                    <img class="rounded-circle m-auto" style="width: 100px"
                         src="<?= $image; ?>" alt="<?= $me->getResult()->username; ?>">
                </div>

                <a class="" href="https://t.me/<?= $me->getResult()->username; ?>?start=shopiumbot"
                   target="_blank">@<?= $me->getResult()->username; ?></a>
                <p class="mt-2 text-muted"><?= $me->getResult()->first_name; ?></p>
            </div>
        <?php } ?>

        <?php OwlCarouselWidget::end(); ?>

    </div>
</section>
<?php

$capability = [
    [
        'name' => 'Каталог товаров',
        'text' => 'Каталог товаров или услуг индивидуальной структуры категорий, атрибутов',
        'icon' => 'shopcart',
    ],
    [
        'name' => 'Скидки',
        'text' => 'Категория, товар, бренд',
        'icon' => 'discount',
    ],
    [
        'name' => 'Прием заказов',
        'text' => 'Корзина, аналог корзины в интернет-магазине. ',
        'icon' => 'cart',
    ],
    [
        'name' => 'Статистика',
        'text' => 'Посещения, активность и т.д.',
        'icon' => 'stats',
    ],
    [
        'name' => 'Рассылки',
        'text' => 'Рассылка сообщений как груповых так и персональных.',
        'icon' => 'envelope-outline',
    ],
    [
        'name' => 'Импорт экспорт товаров',
        'text' => 'формата CSV',
        'icon' => 'upload',
    ],
    [
        'name' => 'Валюта',
        'text' => 'Возможность использования товаров в разной валюте',
        'icon' => 'currencies',
    ],

    [
        'name' => 'Управление товарами прямо в Telegram',
        'text' => 'Редактирование, добавление, удаление',
        // 'text' => 'Администрирование товаров',
        'icon' => 'telegram-outline',
    ],
    [
        'name' => 'RestFul API',
        'text' => 'API позволит интегрировать чат-бота с вашей CRM или сайтом.',
        'icon' => 'tools',
    ],
];
?>
<section id="capability">
    <div class="container pb-5 pt-5">
        <div class="text-center">
            <div class="text-center mb-5"><h2>Возможности</h2></div>
        </div>
        <div class="row">
            <?php foreach ($capability as $item) { ?>
                <div class="col-lg-3 text-center  mb-3 mt-3">

                    <div class="" style="font-size: 44px">
                        <?php if (isset($item['logo'])) { ?>
                            <img src="<?= $item['logo']; ?>" height="50"/>
                        <?php } else { ?>
                            <i class="icon-<?= $item['icon']; ?>"></i>
                        <?php } ?>
                    </div>
                    <div class="h5"><?= $item['name']; ?></div>

                    <p class="text-muted"><?= $item['text']; ?></p>
                </div>


            <?php } ?>

        </div>
    </div>
</section>
<section id="integration">
    <div class="container-fluid bg-dark pt-5 pb-5 text-white">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="text-center">
                        <div class="text-center mb-5"><h2>Интеграция</h2></div>
                    </div>
                    <div class="row">
                        <?php
                        $integrations = [
                            [
                                'name' => 'Новая почта',
                                'text' => '',
                                'badge' => 'NEW',
                                'badgeClass' => 'success',
                                'icon' => 'shopcart',
                                'logo' => $this->context->assetUrl . '/images/Nova_Poshta.svg'
                            ],
                            [
                                'name' => 'PROM.UA',
                                'text' => 'Импорт товаров',
                                'icon' => 'shopcart',
                                'badge' => 'скоро',
                                'badgeClass' => 'warning',
                                'logo' => $this->context->assetUrl . '/images/prom_logo.png'
                            ],


                        ];
                        ?>
                        <?php foreach ($integrations as $item) { ?>
                            <div class="col-lg-3 text-center ">
                                <div class="img-thumbnail2 position-relative">
                                    <?php if (isset($item['badge'])) { ?>
                                        <span class="badge badge-<?= $item['badgeClass']; ?>"
                                              style="position:absolute;right:0;top:0;"><?= $item['badge']; ?></span>
                                    <?php } ?>
                                    <div class="" style="font-size: 44px">
                                        <?php if (isset($item['logo'])) { ?>
                                            <img src="<?= $item['logo']; ?>" height="50"/>
                                        <?php } else { ?>
                                            <i class="icon-<?= $item['icon']; ?>"></i>
                                        <?php } ?>
                                    </div>
                                    <div class="h5 mt-3"><?= $item['name']; ?></div>

                                    <p class="text-white"><?= $item['text']; ?></p>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php

if (false) {
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
            'host' => $data['subdomain'] . '.' . $data['site'],

        ];
        $setSSL = Yii::$app->getModule('user')->hostingApi($ssldata);
        if ($setSSL['status'] == 'success') {
            CMS::dump($setSSL);
        }


        $phpdata = [
            'class' => 'hosting_site_config_php',
            'method' => 'edit',
            'host' => $data['subdomain'] . '.' . $data['site'],
            'php_version' => 'php73'

        ];
        $editPHP = Yii::$app->getModule('user')->hostingApi($phpdata);
        if ($editPHP['status'] == 'success') {
            CMS::dump($editPHP);
        }

        $config_ws = [
            'class' => 'hosting_site_config_ws',
            'method' => 'edit',
            'host' => $data['subdomain'] . '.' . $data['site'],
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


?>


<?php
$model = new \panix\mod\contacts\models\ContactForm();
$send = false;

/*
if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return ActiveForm::validate($model);
}
if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return ['success' => true];
}*/
if ($model->load(Yii::$app->request->post())) {


    if ($model->validate()) {
        $emails = [
            'info@shopiumbot.com',
            //'andrew.panix@gmail.com'
        ];
        foreach ($emails as $email) {
            $model->send($email);
        }

        $send = Yii::t('contacts/default', 'SUCCESS_SEND_FORM');
        Yii::$app->session->setFlash('success', Yii::t('contacts/default', 'SUCCESS_SEND_FORM'));

        return Yii::$app->response->refresh();
    }else{
        //print_r($model->errors);die;
    }
} ?>


<section id="contacts">
    <div class="container mt-4 mb-4 pt-5">
        <div class="row">

            <div class="col-md-5 mb-5 mb-sm-0 pl-0 pr-0">
                <?php if (Yii::$app->session->hasFlash('success')) { ?>
                    <div class="alert alert-success"><?= Yii::$app->session->getFlash('success'); ?></div>
                    <?php
                    $this->registerJs('common.notify("' . Yii::$app->session->getFlash('success') . '","success");');
                    ?>
                <?php } ?>
                <div class="h2 text-center text-md-left mb-4">Остались вопросы?</div>
                <div class="bg-light p-3 radius">

                    <?php

                    $form = ActiveForm::begin([
                        'id' => 'contact-form',
                        // 'layout' => ActiveForm::LAYOUT_INLINE,
                    ]); ?>
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <?= $form->field($model, 'name') ?>
                        <?= $form->field($model, 'email') ?>
                    <?php } ?>

                    <?php
                    if (!Yii::$app->user->phone) {
                        echo $form->field($model, 'phone')->widget(\panix\ext\telinput\PhoneInput::class)->label($model->getAttributeLabel('phone'), ['class' => '']);
                    }
                    ?>
                    <?= $form->field($model, 'text')->textArea(['rows' => 6])->label($model->getAttributeLabel('text'), ['class' => '']) ?>


                    <div class="form-group text-center">
                        <?= Html::submitButton(Yii::t('app/default', 'SEND'), ['class' => 'btn btn-lg btn-secondary', 'name' => 'contact-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>

            </div>
            <div class="col-md-6 offset-md-1 contact-info">
                <div class="pb-5 text-center text-md-left"><h2>Контактная информация</h2></div>
                <div class="mb-3 mt-0 mt-md-5"><?= Html::a(Html::icon('whatsapp-2', ['class' => 'text-success']) . ' 380634892695', 'https://wa.me/380634892695?text=Здравствуйте.'); ?>
                    <sup class="text-muted">WhatsApp</sup></div>
                <div class="mb-3"><?= Html::telegram(Html::icon('telegram-outline', ['class' => 'text-primary']) . ' @Xdesigner18', '@Xdesigner18'); ?>
                    <sup class="text-muted">Telegram</sup></div>
                <div class="mb-3"><?= Html::a(Html::icon('viber', ['class' => 'text-purple']) . ' +38 (063) 489-26-95', 'tel:' . CMS::phone_format('+380634892695')); ?>
                    <sup class="text-muted">Viber</sup></div>
                <div class="mb-3"><?= Html::mailto(Html::icon('envelope-outline') . ' info@shopiumbot.com', 'info@shopiumbot.com'); ?></div>
            </div>
        </div>

    </div>
</section>
<?php
$this->registerJs("
$('#contact-for222m').on('beforeSubmit', function () {
    var form = $(this);
    // отправляем данные на сервер
    $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serializeArray(),
            dataType:'json',
        }
    )
    .done(function(data) {
        if(data.success) {
            // данные сохранены
            common.notify(\"' . $send . '\",\"success\");
        } else {
            // сервер вернул ошибку и не сохранил наши данные
        }
    })
    .fail(function () {
        // не удалось выполнить запрос к серверу
    })

    return false; // отменяем отправку данных формы
})
");
?>
