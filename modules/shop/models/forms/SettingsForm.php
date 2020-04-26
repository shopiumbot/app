<?php

namespace app\modules\shop\models\forms;

use panix\engine\SettingsModel;

class SettingsForm extends SettingsModel
{

    public static $category = 'shop';
    protected $module = 'shop';

    public $per_page;
    public $group_attribute;
    public $label_expire_new;
    public $smart_bc;
    public $smart_title;

    public function rules()
    {
        return [
            [['per_page'], "required"],
            [['group_attribute', 'smart_bc', 'smart_title'], 'boolean'],
            [['label_expire_new'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function defaultSettings()
    {
        return [
            'per_page' => '10,20,30',
            'seo_categories' => false,
            'group_attribute' => false,
            'label_expire_new' => 7,
            'smart_bc' => true,
            'smart_title' => true,
        ];
    }

    public static function labelExpireNew()
    {
        return [
            1 => self::t('LABEL_NEW_DAYS', ['n' => 1]),
            2 => self::t('LABEL_NEW_DAYS', ['n' => 2]),
            3 => self::t('LABEL_NEW_DAYS', ['n' => 3]),
            4 => self::t('LABEL_NEW_DAYS', ['n' => 4]),
            5 => self::t('LABEL_NEW_DAYS', ['n' => 5]),
            6 => self::t('LABEL_NEW_DAYS', ['n' => 6]),
            7 => self::t('LABEL_NEW_DAYS', ['n' => 7]),
            8 => self::t('LABEL_NEW_DAYS', ['n' => 8]),
            9 => self::t('LABEL_NEW_DAYS', ['n' => 9]),
            10 => self::t('LABEL_NEW_DAYS', ['n' => 10]),
            11 => self::t('LABEL_NEW_DAYS', ['n' => 11]),
            12 => self::t('LABEL_NEW_DAYS', ['n' => 12]),
            13 => self::t('LABEL_NEW_DAYS', ['n' => 13]),
            14 => self::t('LABEL_NEW_DAYS', ['n' => 14]),
        ];
    }
}
