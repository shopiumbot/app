<?php

use panix\engine\Html;
use yii\widgets\Breadcrumbs;


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin6">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <div class="navbar-header" data-logobg="skin5">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                    <i class="icon-menu"></i>
                </a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-brand">
                    <a href="/user" class="logo">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <img src="<?= $this->context->asset->baseUrl; ?>/images/logo.svg" alt="homepage"
                                 class="light-logo"/>
                        </b>
                    </a>
                    <a class="sidebartoggler d-none d-md-block" href="javascript:void(0)"
                       data-sidebartype="mini-sidebar">
                        <i class="icon-menu"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                   data-toggle="collapse" data-target="#navbarSupportedContent"
                   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="icon-menu"></i>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin6">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto">
                    <!-- <li class="nav-item d-none d-md-block">
                        <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                            <i class="mdi mdi-menu font-24"></i>
                        </a>
                    </li> -->
                    <!-- ============================================================== -->
                    <!-- Search -->
                    <!-- ============================================================== -->
                    <li class="nav-item search-box">
                        <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
                            <div class="d-flex align-items-center">
                                <i class="icon-search font-20 mr-1"></i>
                                <div class="ml-1 d-none d-sm-block">
                                    <span>Search</span>
                                </div>
                            </div>
                        </a>
                        <form class="app-search position-absolute">
                            <input type="text" class="form-control" placeholder="Search &amp; enter">
                            <a class="srh-btn">
                                <i class="icon-delete"></i>
                            </a>
                        </form>
                    </li>
                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-right">
                    <!-- ============================================================== -->
                    <!-- Messages -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="font-22 icon-comments"></i>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown"
                             aria-labelledby="2">
                                <span class="with-arrow">
                                    <span class="bg-danger"></span>
                                </span>
                            <ul class="list-style-none">
                                <li>
                                    <div class="drop-title text-white bg-danger">
                                        <h4 class="m-b-0 m-t-5">5 New</h4>
                                        <span class="font-light">Messages</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="message-center message-body">
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="user-img">
                                                    <img src="<?= $this->context->asset->baseUrl; ?>/images/2.jpg" alt="user"
                                                         class="rounded-circle">
                                                    <span class="profile-status online pull-right"></span>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Pavan kumar</h5>
                                                <span class="mail-desc">Just see the my admin!</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="user-img">
                                                    <img src="<?= $this->context->asset->baseUrl; ?>/images/2.jpg" alt="user"
                                                         class="rounded-circle">
                                                    <span class="profile-status busy pull-right"></span>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Sonu Nigam</h5>
                                                <span class="mail-desc">I've sung a song! See you at</span>
                                                <span class="time">9:10 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="user-img">
                                                    <img src="<?= $this->context->asset->baseUrl; ?>/images/3.jpg" alt="user"
                                                         class="rounded-circle">
                                                    <span class="profile-status away pull-right"></span>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Arijit Sinh</h5>
                                                <span class="mail-desc">I am a singer!</span>
                                                <span class="time">9:08 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="user-img">
                                                    <img src="<?= $this->context->asset->baseUrl; ?>/images/3.jpg" alt="user"
                                                         class="rounded-circle">
                                                    <span class="profile-status offline pull-right"></span>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Pavan kumar</h5>
                                                <span class="mail-desc">Just see the my admin!</span>
                                                <span class="time">9:02 AM</span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center link text-dark" href="javascript:void(0);">
                                        <b>See all e-Mails</b>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- End Messages -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Comment -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown border-right">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="icon-notification-outline font-22"></i>
                            <span class="badge badge-pill badge-info noti">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                            <ul class="list-style-none">
                                <li>
                                    <div class="drop-title bg-primary text-white">
                                        <h4 class="m-b-0 m-t-5">4 New</h4>
                                        <span class="font-light">Notifications</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="message-center notifications">
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-danger btn-circle">
                                                    <i class="icon-external-link"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Luanch Admin</h5>
                                                <span class="mail-desc">Just see the my new admin!</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-success btn-circle">
                                                    <i class="icon-calendar"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Event today</h5>
                                                <span class="mail-desc">Just a reminder that you have event</span>
                                                <span class="time">9:10 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-info btn-circle">
                                                    <i class="icon-settings"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Settings</h5>
                                                <span class="mail-desc">You can customize this template as you want</span>
                                                <span class="time">9:08 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-primary btn-circle">
                                                    <i class="icon-user"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Pavan kumar</h5>
                                                <span class="mail-desc">Just see the my admin!</span>
                                                <span class="time">9:02 AM</span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center m-b-5 text-dark" href="javascript:void(0);">
                                        <strong>Check all notifications</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- End Comment -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?= $this->context->asset->baseUrl; ?>/images/2.jpg" alt="user" class="rounded-circle"
                                 width="40">
                            <span class="m-l-5 font-medium d-none d-sm-inline-block"><?= Yii::$app->user->getDisplayName(); ?> <i
                                        class="icon-arrow-down"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                            <div class="d-flex no-block align-items-center p-2 bg-primary text-white mb-3">
                                <div class="">
                                    <img src="<?= $this->context->asset->baseUrl; ?>/images/2.jpg" alt="user" class="rounded-circle"
                                         width="60">
                                </div>
                                <div class="ml-2">
                                    <h5 class="mb-0"><?= Yii::$app->user->getDisplayName(); ?></h5>
                                    <p class="mb-0"><a href="/cdn-cgi/l/email-protection" class="__cf_email__">[email&#160;protected]</a>
                                    </p>
                                </div>
                            </div>
                            <div class="profile-dis scrollable">
                                <a class="dropdown-item" href="/user/profile">
                                    <i class="icon-user-outline mr-1 ml-1"></i> Аккаунт</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/user/logout">
                                    <i class="icon-logout mr-1 ml-1"></i> Выход</a>
                                <div class="dropdown-divider"></div>
                            </div>
                            <div class="pl-3 p-2">
                                <a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded">View Profile</a>
                            </div>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar ps-container ps-theme-default ps-active-y">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="icon-telegram-outline"></i>
                        <span class="hide-menu">Telegram-магазин</span>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(Html::icon('folder-open').'<span class="hide-menu">Каталог</span>', ['/shop/category'], ['class' => 'sidebar-link']); ?>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(Html::icon('shopcart').'<span class="hide-menu">Продукция</span>', ['/shop/product'], ['class' => 'sidebar-link']); ?>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(Html::icon('discount').'<span class="hide-menu">Скидки</span>', ['/discount'], ['class' => 'sidebar-link']); ?>
                    </li>
                    <li class="sidebar-item d-none">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-puzzle"></i>
                            <span class="hide-menu">Интеграция</span>
                            <span class="badge badge-pill badge-info ml-auto m-r-15">3</span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="index.html" class="sidebar-link">
                                    <i class="icon-arrow-right"></i>
                                    <span class="hide-menu">CSV</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="index2.html" class="sidebar-link">
                                    <i class="icon-arrow-right"></i>
                                    <span class="hide-menu">EXEL</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(Html::icon('apple').'<span class="hide-menu">Бренды</span>', ['/shop/manufacturer'], ['class' => 'sidebar-link']); ?>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(Html::icon('t').'<span class="hide-menu">Типы товаров</span>', ['/shop/type'], ['class' => 'sidebar-link']); ?>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(Html::icon('filter').'<span class="hide-menu">Атрибуты</span>', ['/shop/attribute'], ['class' => 'sidebar-link']); ?>
                    </li>

                    <li class="sidebar-item">
                        <?= Html::a(Html::icon('settings').'<span class="hide-menu">Настройки</span>', ['/shop/settings'], ['class' => 'sidebar-link']); ?>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-cart"></i>
                            <span class="hide-menu">Заказы</span>
                            <span class="badge badge-pill badge-success ml-auto m-r-15">3</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <?= Html::a(Html::icon('list').'<span class="hide-menu">Список заказов</span>', ['/cart'], ['class' => 'sidebar-link']); ?>
                            </li>
                            <li class="sidebar-item">
                                <?= Html::a(Html::icon('delivery').'<span class="hide-menu">Доставка</span>', ['/'], ['class' => 'sidebar-link']); ?>
                            </li>
                            <li class="sidebar-item">
                                <?= Html::a(Html::icon('creditcard').'<span class="hide-menu">Оплата</span>', ['/'], ['class' => 'sidebar-link']); ?>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-small-cap">
                        <i class="icon-puzzle"></i>
                        <span class="hide-menu">Интеграция</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-upload"></i>
                            <span class="hide-menu">Импорт</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <?= Html::a(Html::icon('file-csv').'<span class="hide-menu">CSV - формат</span>', ['/cart'], ['class' => 'sidebar-link']); ?>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-download"></i>
                            <span class="hide-menu">Экспорт</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <?= Html::a(Html::icon('file-csv').'<span class="hide-menu">CSV - формат</span>', ['/cart'], ['class' => 'sidebar-link']); ?>
                            </li>
                        </ul>
                    </li>




                    <li class="nav-small-cap">
                        <i class="icon-books"></i>
                        <span class="hide-menu">Дополнительный</span>
                    </li>

                    <li class="sidebar-item">
                        <?= Html::a(Html::icon('info').'<span class="hide-menu">Документация</span>', ['/user/logout'], ['class' => 'sidebar-link']); ?>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(Html::icon('tools').'<span class="hide-menu">API</span>', ['/user/logout'], ['class' => 'sidebar-link']); ?>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(Html::icon('logout').'<span class="hide-menu">Выход</span>', ['/user/logout'], ['class' => 'sidebar-link']); ?>
                    </li>

                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <div class="page-wrapper">




            <?= $content; ?>



        <footer class="footer text-center">
            {copyright}
        </footer>

    </div>

</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
