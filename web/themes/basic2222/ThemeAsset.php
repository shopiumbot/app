<?php

namespace app\web\themes\basic;

use panix\engine\web\AssetBundle;

/**
 * Class ThemeAsset
 * @package app\web\themes\basic
 */
class ThemeAsset extends AssetBundle
{

    private $_theme;

    public function init()
    {
        $this->_theme = \Yii::$app->settings->get('app', 'theme');
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }

    public $js = [
        'js/jquery.magnific-popup.min.js',
        'js/wow.min.js',
        'js/owl.carousel.min.js',
        'js/slick.min.js',
        'js/rsmenu-main.js',
        'js/plugins.js',
        'js/main.js'
    ];

    public $css = [
      //  'css/bootstrap.min.css',
        'css/animate.css',
        'css/hover-min.css',
        'css/owl.carousel.css',
        'css/slick.css',
        'css/off-canvas.css',
        'css/rsmenu-main.css',
        'css/magnific-popup.css',
        'css/rsmenu-transitions.css',
        'css/style.css',
        'css/spacing.css',
        'css/responsive.css',
    ];

    public $depends = [
        'panix\engine\assets\JqueryCookieAsset',
        'panix\engine\assets\TouchPunchAsset',
        'panix\engine\assets\CommonAsset',
    ];

}
