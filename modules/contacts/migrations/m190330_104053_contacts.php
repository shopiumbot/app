<?php

namespace app\modules\contacts\migrations;

/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m190330_104053_contacts
 */

use app\modules\contacts\models\Feedback;
use panix\engine\db\Migration;

class m190330_104053_contacts extends Migration
{
    public $settingsForm = 'app\modules\contacts\models\SettingsForm';

    public function up()
    {
        $this->createTable(Feedback::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'ordern' => $this->integer()->unsigned(),
        ]);
        $this->loadSettings();
    }

    public function down()
    {
    }

}
