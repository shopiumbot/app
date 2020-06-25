<?php

namespace app\modules\user\components;

use panix\engine\Html;
use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use panix\engine\base\Model;
use panix\engine\components\Settings;
use yii\helpers\VarDumper;

/**
 * Class SettingsModel
 * @package panix\engine
 */
class SettingsModel extends Model
{
    public static $category = null;
    private $component = 'clientSettings';

    public static function tableName()
    {
        return Settings::tableName();
    }

    public static function defaultSettings()
    {
        return [];
    }
    public function submitButton()
    {
        return Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']);
    }
    public function init()
    {
        if (!isset($this->module)) {
            throw new InvalidConfigException(Yii::t('yii', 'Missing required parameters: {params}', [
                'params' => 'module'
            ]));
        }
        if (static::$category == null) {
            static::$category = $this->module;
        }

        $this->setAttributes((array)Yii::$app->get($this->component)->get(static::$category));
    }



    public function save()
    {

        Yii::$app->get($this->component)->set(static::$category, $this->attributes);
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (parent::validate($attributeNames, $clearErrors)) {
            Yii::$app->session->addFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
            return true;
        } else {
            //print_r($this->getErrors());die;
            Yii::$app->session->addFlash("error", Yii::t('app/default', 'ERROR_UPDATE'));
            return false;
        }
    }


}
