<?php

namespace app\modules\csv\models;

use app\modules\csv\components\CsvImporter;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class UploadForm
 * @property string $files
 * @package app\modules\csv\models
 */
class UploadForm extends Model
{

    const files_max_size = 1024 * 1024 * 50;

    protected $filesExt = ['zip'];

    public $files;

    public function rules()
    {
        return [
            [['files'], 'file', 'extensions' => ArrayHelper::merge($this->filesExt, CsvImporter::$extension), 'maxSize' => self::files_max_size],
        ];
    }

    public function attributeLabels()
    {
        return [
            'files' => Yii::t('csv/default', 'FILES', implode(', ', ArrayHelper::merge($this->filesExt, CsvImporter::$extension))),
        ];
    }
}