<?php

namespace app\modules\csv\models;

use panix\engine\SettingsModel;

/**
 * Class SettingsForm
 * @package app\modules\csv\models
 */
class SettingsForm extends SettingsModel
{

    protected $module = 'csv';
    public static $category = 'csv';

    public $pagenum;

    public function rules()
    {
        return [
            ['pagenum', 'required'],
        ];
    }

    public static function defaultSettings()
    {
        return [
            'pagenum' => 300,
        ];
    }
}
