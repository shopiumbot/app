<?php

use panix\engine\Html;
use yii\widgets\Breadcrumbs;


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


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Preloader area start here -->
<div id="loading" class="icon-preloader">
    <div class="loader">
        <div class="animate3">
            <img src="<?= $this->context->assetUrl;?>/images/load.png" alt="Preloader Image animate3">
        </div>
    </div>
</div>
<!--End preloader here -->

<!--Header Section Start-->
<header id="rs-header" class="transparent-header style3">
    <!-- Header Menu Start -->
    <div class="menu-area menu-sticky pt-10">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-3">
                    <div class="logo-area">
                        <a href="index.html"><img src="<?= $this->context->assetUrl;?>/images/logo-white.png" alt="logo"></a>
                    </div>
                </div>
                <div class="col-sm-9 mobile-menu-area">
                    <div class="rs-menu-area display-flex-center">
                        <div class="main-menu">
                            <a class="rs-menu-toggle"><i class="fa fa-bars"></i>Menu</a>
                            <nav class="rs-menu">
                                <ul class="nav-menu">
                                    <!-- Home -->
                                    <li class="current-menu-item current_page_item menu-item-has-children">
                                        <a href="#">Home</a>
                                        <ul class="sub-menu">
                                            <li><a href="index.html">Home One</a></li>
                                            <li><a href="index2.html">Home Two</a></li>
                                            <li class="active"><a href="index3.html">Home Three</a></li>
                                        </ul>
                                    </li>
                                    <!-- End Home -->

                                    <li><a href="about.html">About</a></li>

                                    <li><a href="features.html">Features</a></li>

                                    <!-- Pages Mega Menu Start -->
                                    <li class="rs-mega-menu mega-rs menu-item-has-children"> <a href="#">Pages</a>
                                        <ul class="mega-menu">
                                            <li class="mega-menu-container">
                                                <div class="mega-menu-innner">
                                                    <div class="single-megamenu">
                                                        <ul class="sub-menu">
                                                            <li><a href="software-demo.html">Software Demo</a> </li>
                                                            <li><a href="mobile-app.html">Mobile App</a> </li>
                                                            <li><a href="team.html">Team Page</a> </li>
                                                            <li><a href="privacy.html">Privacy Policy Page</a> </li>
                                                        </ul>
                                                    </div>
                                                    <div class="single-megamenu">
                                                        <ul class="sub-menu">
                                                            <li><a href="pricing.html">Pricing Plan</a> </li>
                                                            <li><a href="chatbot.html">ChatBot</a> </li>
                                                            <li><a href="login.html">Login</a> </li>
                                                            <li><a href="register.html">Register</a> </li>
                                                        </ul>
                                                    </div>
                                                    <div class="single-megamenu">
                                                        <ul class="sub-menu">
                                                            <li><a href="software-download.html">Download</a> </li>
                                                            <li><a href="coming-soon.html">Coming Soon</a> </li>
                                                            <li><a href="error.html">404 Error</a> </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul> <!-- //.mega-menu -->
                                    </li>
                                    <!--Pages Mega Menu End -->

                                    <!-- Shop Menu Start -->
                                    <li class="menu-item-has-children"><a href="shop.html">Shop</a>
                                        <ul class="sub-menu">
                                            <li class="menu-item-has-children"><a href="shop.html">Shop</a></li>
                                            <li><a href="shop-single.html">Shop Single</a></li>
                                            <li><a href="cart.html">Cart</a></li>
                                            <li><a href="checkout.html">Checkout</a></li>
                                        </ul>
                                    </li>
                                    <!-- Shop Menu End -->

                                    <li class="menu-item-has-children"><a href="#">Blog</a>
                                        <ul class="sub-menu">
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="blog-left.html">Blog Left Sidebar</a></li>
                                            <li><a href="blog-right.html">Blog Right Sidebar</a></li>
                                            <li><a href="blog-details.html">Blog Details</a></li>
                                        </ul>
                                    </li>

                                    <li> <a href="contact.html">Contact</a> </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="right-bar-icon text-right">
                            <ul>
                                <li class="icon-bar cart-inner mini-cart-active">
                                    <a class="cart-icon"><i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                    </a>
                                    <div class="woocommerce-mini-cart text-left">
                                        <ul class="cart-icon-product-list">
                                            <li class="display-flex">
                                                <div class="icon-cart">
                                                    <a href="#"><i class="fa fa-times"></i></a>
                                                </div>
                                                <div class="product-info">
                                                    <a href="cart.html">Cordless Drill</a><br>
                                                    <span class="quantity">1 × $30.00</span>
                                                </div>
                                                <div class="product-image">
                                                    <a href="cart.html"><img width="40" src="images/shop/4.jpg" alt="Product Image"></a>
                                                </div>
                                            </li>
                                            <li class="display-flex">
                                                <div class="icon-cart">
                                                    <a href="#"><i class="fa fa-times"></i></a>
                                                </div>
                                                <div class="product-info">
                                                    <a href="cart.html">Spirit Level</a><br>
                                                    <span class="quantity">1 × $30.00</span>
                                                </div>
                                                <div class="product-image">
                                                    <a href="cart.html"><img width="40" src="images/shop/5.jpg" alt="Product Image"></a>
                                                </div>
                                            </li>
                                        </ul>

                                        <div class="total-price text-center">
                                            <span class="subtotal">Subtotal:</span>
                                            <span class="current-price">$85.00</span>
                                        </div>

                                        <div class="cart-btn text-center">
                                            <a class="readon" href="cart.html">View Cart</a>
                                            <a class="readon" href="checkout.html">Check Out</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="icon-bar "><a class="hidden-xs rs-search" data-target=".search-modal" data-toggle="modal" href="#"><i class="fa fa-search"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Menu End -->
</header>
<!--Header Section End-->

<!-- Bannner Section Start Here -->
<div class="home-banner">
    <div class="container">
        <div class="banner-item">
            <div class="banner-text text-center">
                <h1 class="white-color mb-30 semi-bold uppercase" data-animation-in="slideInDown" data-animation-out="animate-out slideOutUp">Natural Language <br>Processing</h1>
                <div class="btn-banner">
                    <a href="#" class="readon banner radius" data-animation-in="slideInUp" data-animation-out="animate-out slideOutDown">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bannner Section end Here -->

<!-- About Section Start-->
<div id="neuron-about" class="neuron-about white-bg pt-90 pb-90 md-pt-80 md-pb-70">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 padding-0 order-last md-mb-30 col-padding-md">
                <div class="neuron-about-img-part">
                    <div class="about-img">
                        <img src="<?= $this->context->assetUrl;?>/images/about-style3.png" alt="About Image">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sec-title mb-40">
                    <h2 class="title2 semi-bold mb-20">Convert Your Unstructured Data Into Actionable Insights With NLP Techniques</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis at dictum risus, non arcu. Quisque aliquam posuere tortor, sit amet convallis nunc scelerisque in.</p>

                    <p class="margin-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore eius molestiae facere, natus reprehenderit eaque eum, autem ipsam. Magni, error. Tempora odit laborum iure inventore possimus laboriosam qui nam. Fugit!</p>
                </div>
                <div class="about-btn">
                    <a class="readon style3 radius" href="#">Learn More</a>
                </div>
            </div>
        </div>
        <div class="row col-20 pt-100 md-pt-80">
            <div class="col-lg-4 col-md-6 sm-mb-30">
                <div class="single-about no-bg-style top-border">
                    <div class="about-title">
                        <h4 class="title mb-20">Powered by Google's Machine Learning</h4>
                    </div>
                    <div class="about-desc">
                        <p class="desc-txt">Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide wit additional clickthroughs</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-about no-bg-style top-border">
                    <div class="about-title">
                        <h4 class="title mb-20">Built on Google Infrastructure</h4>
                    </div>
                    <div class="about-desc">
                        <p class="desc-txt">Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide wit additional clickthroughs</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 hidden-md">
                <div class="single-about no-bg-style top-border">
                    <div class="about-title">
                        <h4 class="title mb-20">Optimized for the Google Assistant</h4>
                    </div>
                    <div class="about-desc">
                        <p class="desc-txt">Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide wit additional clickthroughs</p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .container end -->
</div>
<!-- About Section End-->

<!-- Services Section Start-->
<div class="neuron-about gray-bg pt-90 pb-100 md-pt-70 md-pb-80">
    <div class="container">
        <div class="sec-title text-center mb-45">
            <h2 class="title extra-none title-color mb-0">Develop a Powerful NLP Application <br>That Includes</h2>
        </div>
        <div class="row col-20">
            <div class="col-lg-4 col-md-6 mb-40">
                <div class="single-about style4 box-shadow">
                    <div class="about-title">
                        <h3 class="title">Machine Learning</h3>
                    </div>
                    <div class="about-desc">
                        <p class="desc-txt">Capitalize on low hanging fruit to identify a ball park value added activity to beta test. Override the digital divide with additional</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-40">
                <div class="single-about style4 box-shadow">
                    <div class="about-title">
                        <h3 class="title">Semantic Search</h3>
                    </div>
                    <div class="about-desc">
                        <p class="desc-txt">Capitalize on low hanging fruit to identify a ball park value added activity to beta test. Override the digital divide with additional</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-40">
                <div class="single-about style4 box-shadow">
                    <div class="about-title">
                        <h3 class="title">Speech Recognition</h3>
                    </div>
                    <div class="about-desc">
                        <p class="desc-txt">Capitalize on low hanging fruit to identify a ball park value added activity to beta test. Override the digital divide with additional</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 md-mb-40">
                <div class="single-about style4 box-shadow">
                    <div class="about-title">
                        <h3 class="title">Information Extraction</h3>
                    </div>
                    <div class="about-desc">
                        <p class="desc-txt">Capitalize on low hanging fruit to identify a ball park value added activity to beta test. Override the digital divide with additional</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sm-mb-40">
                <div class="single-about style4 box-shadow">
                    <div class="about-title">
                        <h3 class="title">Machine Translation</h3>
                    </div>
                    <div class="about-desc">
                        <p class="desc-txt">Capitalize on low hanging fruit to identify a ball park value added activity to beta test. Override the digital divide with additional</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-about style4 box-shadow">
                    <div class="about-title">
                        <h3 class="title">Question Answering</h3>
                    </div>
                    <div class="about-desc">
                        <p class="desc-txt">Capitalize on low hanging fruit to identify a ball park value added activity to beta test. Override the digital divide with additional</p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .container end -->
</div>
<!-- Services Section End-->

<!-- Work Section Start -->
<div id="neuron-work" class="neuron-work sec-bg pt-90 pb-100 md-pt-70 md-pb-80">
    <div class="container">
        <div class="row mb-45 md-mb-30">
            <div class="col-lg-4">
                <div class="sec-title">
                    <h2 class="title2 title-color semi-bold margin-0">How Neuron Natural Language Works</h2>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="title-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis at dictum risus, non suscipit arcu. Quisque aliquam posuere tortor, sit amet convallis nunc scelerisque in.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore eius molestiae facere, natus reprehenderit eaque eum, autem ipsam. Magni, error. Tempora odit laborum iure inventore possimus laboriosam qui nam. Fugit!</div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 md-mb-30">
                <div class="neuron-work-img-part display-flex align-items-center">
                    <div class="work-img mr-50">
                        <img src="images/about/phone.png" alt="About Image">
                    </div>
                    <div class="work-img">
                        <img src="images/about/arrow-shape.png" alt="About Image">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row align-items-center">
                    <div class="col-lg-4 md-mb-30">
                        <div class="language-work style3 text-center long-work box-shadow">
                            <div class="work-icon mb-10">
                                <i class="flaticon-artificial-intelligence-1"></i>
                            </div>
                            <div class="work-title">
                                <h4 class="title title-color semi-bold mb-0">Natural Language Processing (NLP) Layer</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 md-mb-30">
                        <div class="work-shape-img-part text-center">
                            <div class="shape-img mb-125 md-mb-50">
                                <img src="images/about/arrow-shape.png" alt="About Image">
                            </div>
                            <div class="shape-img">
                                <img src="images/about/arrow-shape.png" alt="About Image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="language-work style3 text-center box-shadow mb-30">
                            <div class="work-icon mb-10">
                                <i class="flaticon-brain"></i>
                            </div>
                            <div class="work-title">
                                <h4 class="title title-color semi-bold mb-0">Knowledge Base/CMS <span>(Source Content)</span></h4>
                            </div>
                        </div>
                        <div class="language-work style3 text-center box-shadow">
                            <div class="work-icon mb-10">
                                <i class="flaticon-database"></i>
                            </div>
                            <div class="work-title">
                                <h4 class="title title-color semi-bold mb-0">Data Storage<span>(History & Analytics)</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Work Section End -->

<!-- Counter Section Start Here-->
<div id="neuron-counter-area" class="neuron-counter-area style2 gradient-bg3-section pt-100 pb-95 md-pt-80 md-pb-75">
    <div class="container">
        <div class="row neuron-count">
            <!-- COUNTER-LIST START -->
            <div class="col-lg-3 col-md-6 md-mb-50">
                <div class="neuron-counter-part text-center">
                    <div class="counter-text text-center">
                        <div class="neuron-counter white-color">4000</div>
                        <h4 class="counter-txt white-color">Complete Project</h4>
                    </div>
                </div>
            </div>
            <!-- COUNTER-LIST END -->

            <!-- COUNTER-LIST START -->
            <div class="col-lg-3 col-md-6 md-mb-50">
                <div class="neuron-counter-part text-center">
                    <div class="counter-text text-center">
                        <div class="neuron-counter white-color">600</div>
                        <h4 class="counter-txt white-color">NLP Experts</h4>
                    </div>
                </div>
            </div>
            <!-- COUNTER-LIST END -->

            <!-- COUNTER-LIST START -->
            <div class="col-lg-3 col-md-6 sm-mb-50">
                <div class="neuron-counter-part text-center">
                    <div class="counter-text text-center">
                        <div class="neuron-counter white-color">3500</div>
                        <h4 class="counter-txt white-color">Satisfied Clients</h4>
                    </div>
                </div>
            </div>
            <!-- COUNTER-LIST END -->

            <!-- COUNTER-LIST START -->
            <div class="col-lg-3 col-md-6">
                <div class="neuron-counter-part text-center">
                    <div class="counter-text text-center">
                        <div class="neuron-counter white-color">8000</div>
                        <h4 class="counter-txt white-color">Industries Served</h4>
                    </div>
                </div>
            </div>
            <!-- COUNTER-LIST END -->
        </div>
    </div>
</div>
<!-- Counter Section End Here-->

<!-- Services Section Start-->
<div class="neuron-about sec-bg pt-90 pb-100 md-pt-70 md-pb-80">
    <div class="container">
        <div class="sec-title text-center mb-45">
            <h2 class="title extra-none title-color mb-0">We Provide Some Speciality <br>Our Neuron NLP</h2>
        </div>
        <div class="row col-20">
            <div class="col-lg-3 col-md-6 mb-40">
                <div class="single-about style4 icon-style box-shadow">
                    <div class="about-icon">
                        <i class="flaticon-abc"></i>
                    </div>
                    <div class="about-title">
                        <h4 class="title mb-20">Vocabulary Expansion</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-40">
                <div class="single-about style4 icon-style box-shadow">
                    <div class="about-icon">
                        <i class="flaticon-brain"></i>
                    </div>
                    <div class="about-title">
                        <h4 class="title mb-20">Tense of the Verbs</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-40">
                <div class="single-about style4 icon-style box-shadow">
                    <div class="about-icon">
                        <i class="flaticon-abc"></i>
                    </div>
                    <div class="about-title">
                        <h4 class="title mb-20">Vocabulary Transfer</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-40">
                <div class="single-about style4 icon-style box-shadow">
                    <div class="about-icon">
                        <i class="flaticon-business-and-finance"></i>
                    </div>
                    <div class="about-title">
                        <h4 class="title mb-20">Predefined Synonyms</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 md-mb-40">
                <div class="single-about style4 icon-style box-shadow">
                    <div class="about-icon">
                        <i class="flaticon-font"></i>
                    </div>
                    <div class="about-title">
                        <h4 class="title mb-20">Capitalization</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 md-mb-40">
                <div class="single-about style4 icon-style box-shadow">
                    <div class="about-icon">
                        <i class="flaticon-contract"></i>
                    </div>
                    <div class="about-title">
                        <h4 class="title mb-20">Contractions</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 sm-mb-40">
                <div class="single-about style4 icon-style box-shadow">
                    <div class="about-icon">
                        <i class="flaticon-speech-bubble"></i>
                    </div>
                    <div class="about-title">
                        <h4 class="title mb-20">Message Personalization</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="single-about style4 icon-style box-shadow">
                    <div class="about-icon">
                        <i class="flaticon-binary-code"></i>
                    </div>
                    <div class="about-title">
                        <h4 class="title mb-20">Digit vs Numeric Words</h4>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .container end -->
</div>
<!-- Services Section End-->

<!-- Testimonial Style Start -->
<div class="neuron-testimonial white-bg pt-100 pb-100 md-pt-80 md-pb-80">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 pr-100 col-padding-md md-mb-30">
                <div class="sec-title">
                    <h2 class="title extra-none title-color mb-20">What Our Client Says About Us</h2>
                    <span class="title-desc">Bring to the table win-win survival strategies to ensure proac tive domination. At the end of the day, going forward, a news normal that evolved generation</span>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="testimonial-vertical-carousel box-shadow">
                    <div class="row align-items-center">
                        <div class="col-md-2 padding-0 sm-mb-30 col-padding-sm">
                            <div class="slider-nav">
                                <div class="item">
                                    <img src="images/testimonial/1.jpg" alt="image" draggable="false" />
                                </div>
                                <div class="item">
                                    <img src="images/testimonial/2.jpg" alt="image" draggable="false" />
                                </div>
                                <div class="item">
                                    <img src="images/testimonial/3.jpg" alt="image" draggable="false" />
                                </div>
                                <div class="item">
                                    <img src="images/testimonial/4.jpg" alt="image" draggable="false" />
                                </div>
                                <div class="item">
                                    <img src="images/testimonial/3.jpg" alt="image" draggable="false" />
                                </div>
                                <div class="item">
                                    <img src="images/testimonial/4.jpg" alt="image" draggable="false" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 padding-0">
                            <div class="slider-for">
                                <div class="item">
                                    <p class="author-desc">I must explain to you how all this mistaken idea of de nounc ing pleasure and praising pain was born and I will give you a  com plete account of the system, and ex pound the actual teach ings of the great explorer of the truth. Credibly pontifi cate highly efficient manufactured products and enabled data. and ex pound the actual teach ings.</p>
                                    <div class="author-info">
                                        <h6 class="name">Luise Henrikes</h6>
                                    </div>
                                </div>
                                <div class="item">
                                    <p class="author-desc">I must explain to you how all this mistaken idea of de nounc ing pleasure and praising pain was born and I will give you a  com plete account of the system, and ex pound the actual teach ings of the great explorer of the truth. Credibly pontifi cate highly efficient manufactured products and enabled data. and ex pound the actual teach ings.</p>
                                    <div class="author-info">
                                        <h6 class="name">Luise Henrikes</h6>
                                    </div>
                                </div>
                                <div class="item">
                                    <p class="author-desc">I must explain to you how all this mistaken idea of de nounc ing pleasure and praising pain was born and I will give you a  com plete account of the system, and ex pound the actual teach ings of the great explorer of the truth. Credibly pontifi cate highly efficient manufactured products and enabled data. and ex pound the actual teach ings.</p>
                                    <div class="author-info">
                                        <h6 class="name">Luise Henrikes</h6>
                                    </div>
                                </div>
                                <div class="item">
                                    <p class="author-desc">I must explain to you how all this mistaken idea of de nounc ing pleasure and praising pain was born and I will give you a  com plete account of the system, and ex pound the actual teach ings of the great explorer of the truth. Credibly pontifi cate highly efficient manufactured products and enabled data. and ex pound the actual teach ings.</p>
                                    <div class="author-info">
                                        <h6 class="name">Luise Henrikes</h6>
                                    </div>
                                </div>
                                <div class="item">
                                    <p class="author-desc">I must explain to you how all this mistaken idea of de nounc ing pleasure and praising pain was born and I will give you a  com plete account of the system, and ex pound the actual teach ings of the great explorer of the truth. Credibly pontifi cate highly efficient manufactured products and enabled data. and ex pound the actual teach ings.</p>
                                    <div class="author-info">
                                        <h6 class="name">Luise Henrikes</h6>
                                    </div>
                                </div>
                                <div class="item">
                                    <p class="author-desc">I must explain to you how all this mistaken idea of de nounc ing pleasure and praising pain was born and I will give you a  com plete account of the system, and ex pound the actual teach ings of the great explorer of the truth. Credibly pontifi cate highly efficient manufactured products and enabled data. and ex pound the actual teach ings.</p>
                                    <div class="author-info">
                                        <h6 class="name">Luise Henrikes</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial Style End -->

<!-- Author Section Start -->
<div id="neuron-author" class="neuron-author gradient-bg3-section pt-90 pb-90 md-pt-70 md-pb-70">
    <div class="container">
        <div class="sec-title text-center mb-45">
            <h2 class="title extra-none white-color mb-0">Reach More Audiences <br>Wherever They Are </h2>
        </div>
        <div class="rs-carousel owl-carousel wow" data-loop="true" data-items="3" data-margin="40" data-autoplay="true" data-autoplay-timeout="9000" data-smart-speed="2000" data-dots="false" data-nav="false" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="1" data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="3" data-md-device-nav="false" data-md-device-dots="false">
            <div class="single-author text-center">
                <div class="author-img">
                    <a href="#"><img src="images/author/1.png" alt=""></a>
                </div>
                <div class="author-details">
                    <h4 class="author-title semi-bold mb-20 mt-25"><a href="#">On Any Platform</a></h4>
                    <p class="author-desc margin-0">Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide wit additional clickthroughs</p>
                </div>
            </div>
            <div class="single-author text-center">
                <div class="author-img">
                    <a href="#"><img src="images/author/2.png" alt=""></a>
                </div>
                <div class="author-details">
                    <h4 class="author-title semi-bold mb-20 mt-25"><a href="#">Across Devices</a></h4>
                    <p class="author-desc margin-0">Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide wit additional clickthroughs</p>
                </div>
            </div>
            <div class="single-author text-center">
                <div class="author-img">
                    <a href="#"><img src="images/author/3.png" alt=""></a>
                </div>
                <div class="author-details">
                    <h4 class="author-title semi-bold mb-20 mt-25"><a href="#">Around the World</a></h4>
                    <p class="author-desc margin-0">Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide wit additional clickthroughs</p>
                </div>
            </div>
            <div class="single-author text-center">
                <div class="author-img">
                    <a href="#"><img src="images/author/2.png" alt=""></a>
                </div>
                <div class="author-details">
                    <h4 class="author-title semi-bold mb-20 mt-25"><a href="#">Across Devices</a></h4>
                    <p class="author-desc margin-0">Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide wit additional clickthroughs</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Author Section End -->

<!-- Blog Section Start -->
<div id="neuron-blog" class="neuron-blog pt-90 pb-100 md-pt-70 md-pb-80">
    <div class="container">
        <div class="row mb-45 md-mb-20">
            <div class="col-lg-4 md-mb-15">
                <div class="sec-title">
                    <h2 class="title2 title-color semi-bold margin-0">Our Latest News & Blog Post</h2>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="title-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis at dictum risus, non suscipit arcu. Quisque aliquam posuere tortor, sit amet convallis nunc scelerisque in.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore eius molestiae facere, natus reprehenderit eaque eum, autem ipsam. Magni, error. Tempora odit laborum iure inventore possimus laboriosam qui nam. Fugit!</div>
            </div>
        </div>
        <div class="rs-carousel owl-carousel wow" data-loop="true" data-items="3" data-margin="30" data-autoplay="true" data-autoplay-timeout="9000" data-smart-speed="2000" data-dots="false" data-nav="false" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="1" data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="3" data-md-device-nav="false" data-md-device-dots="false">
            <div class="single-blog style3 white-bg text-center">
                <div class="blog-img">
                    <a href="#"><img src="images/blog/1.jpg" alt=""></a>
                </div>
                <div class="blog-details">
                    <ul class="blog-meta">
                        <li><i class="fa fa-calendar-check-o" aria-hidden="true"></i>Nov 28, 2019</li>
                        <li><i class="fa fa-user-o" aria-hidden="true"></i>Admin</li>
                        <li><span>10</span>Comments</li>
                    </ul>
                    <div class="blog-desc">
                        <h3 class="blog-title"><a href="#">Man in Red Plaid Shirt Talking on Phone Terrace</a></h3>
                    </div>
                </div>
            </div>
            <div class="single-blog style3 white-bg text-center">
                <div class="blog-img">
                    <a href="#"><img src="images/blog/2.jpg" alt=""></a>
                </div>
                <div class="blog-details">
                    <ul class="blog-meta">
                        <li><i class="fa fa-calendar-check-o" aria-hidden="true"></i>Nov 28, 2019</li>
                        <li><i class="fa fa-user-o" aria-hidden="true"></i>Admin</li>
                        <li><span>10</span>Comments</li>
                    </ul>
                    <div class="blog-desc">
                        <h3 class="blog-title"><a href="#">Man in Red Plaid Shirt Talking on Phone Terrace</a></h3>
                    </div>
                </div>
            </div>
            <div class="single-blog style3 white-bg text-center">
                <div class="blog-img">
                    <a href="#"><img src="images/blog/3.jpg" alt=""></a>
                </div>
                <div class="blog-details">
                    <ul class="blog-meta">
                        <li><i class="fa fa-calendar-check-o" aria-hidden="true"></i>Nov 28, 2019</li>
                        <li><i class="fa fa-user-o" aria-hidden="true"></i>Admin</li>
                        <li><span>10</span>Comments</li>
                    </ul>
                    <div class="blog-desc">
                        <h3 class="blog-title"><a href="#">Man in Red Plaid Shirt Talking on Phone Terrace</a></h3>
                    </div>
                </div>
            </div>
            <div class="single-blog style3 white-bg text-center">
                <div class="blog-img">
                    <a href="#"><img src="images/blog/2.jpg" alt=""></a>
                </div>
                <div class="blog-details">
                    <ul class="blog-meta">
                        <li><i class="fa fa-calendar-check-o" aria-hidden="true"></i>Nov 28, 2019</li>
                        <li><i class="fa fa-user-o" aria-hidden="true"></i>Admin</li>
                        <li><span>10</span>Comments</li>
                    </ul>
                    <div class="blog-desc">
                        <h3 class="blog-title"><a href="#">Man in Red Plaid Shirt Talking on Phone Terrace</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog Section End -->

<!-- Footer Start -->
<footer id="rs-footer" class="rs-footer style3">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-sm-12 single-footer-column mb-md-30">
                    <div class="about-widget pr-20">
                        <div class="footer-logo">
                            <img src="images/logo-white.png" alt="Footer Logo">
                        </div>
                        <div class="footer-info">
                            <p class="footer-desc">Lorem ipsum dolor sit amet, conse turini adipiscing elit, sed do eiusmod tempor in cididunt ut labore. </p>
                        </div>
                        <ul class="social-links">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12 col-sm-12 single-footer-column">
                    <h4 class="footer-title white-color">Work Hours</h4>
                    <p>10.00 AM - 6.00 PM , Monday - Saturday</p>
                    <p>Our Support and Sales team is available 24 * 7 to answer your queries</p>
                </div>

                <div class="col-lg-3 col-md-12 col-sm-12 single-footer-column mb-md-30">
                    <div class="footer-menu">
                        <h4 class="footer-title white-color">Navigate</h4>
                        <div class="row">
                            <div class="col-lg-6 pr-0">
                                <ul>
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="features.html">Features</a></li>
                                    <li><a href="mobile-app.html">Mobile App</a></li>
                                    <li><a href="software-demo.html">Software Demo</a></li>
                                    <li><a href="software-download.html">Software Download</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="team.html">Team</a></li>
                                    <li><a href="chatbot.html">ChatBot</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 single-footer-column">
                    <div class="footer-menu">
                        <h4 class="footer-title white-color">Privacy & Tos</h4>
                        <ul>
                            <li><a href="privacy.html">Privacy</a></li>
                            <li><a href="contact.html">Contact</a></li>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="register.html">Register</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="chatbox-part style3">
                <div class="chatbox box-shadow white-bg">
                    <div class="chatbox-top gradient-bg3">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="chat-img">
                                    <img src="images/team/chat.png" alt="">
                                    <span class="active-icon"></span>
                                </div>
                                <div class="chat-identity pl-10">
                                    <h4 class="chat-title white-color mb-0">ChatBot</h4>
                                    <span class="active-status white-color">Active</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="close-icon">
                                    <i class="flaticon-error"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chatbox-text text-center">
                        <p>Hello Friend, I can help you with anything related to chatbots!</p>
                        <p class="mb-0">Let me know if you're planning to create a chatbot for your business!﻿</p>
                    </div>
                    <div class="chatbox-btn">
                        <a class="readon style3 radius" href="#">Let’s Start a Chat</a>
                    </div>
                </div>
                <div class="chat-icon text-center">
                    <i class="flaticon-chat"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="copyright text-center">
                <p>© Copyrights 2019 <a href="#">AuburnForest</a></p>
            </div>
        </div>
    </div>
</footer>
<!-- Footer End -->

<!-- Search Modal Start -->
<div aria-hidden="true" class="modal fade search-modal" role="dialog" tabindex="-1">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="flaticon-cross-out"></i>
    </button>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="search-block clearfix">
                <form>
                    <div class="form-group">
                        <input class="form-control" placeholder="Searching..." type="text">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>{copyright}



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
