<?php

/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m000002_202400_settings
 */

use panix\engine\db\Migration;
use panix\engine\components\Settings;

class m000002_202400_settings extends Migration
{

    public function up()
    {
        $this->createTable(Settings::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'category' => $this->string(255)->notNull(),
            'param' => $this->string(255),
            'value' => $this->text(),
        ]);

        $this->createIndex('param', Settings::tableName(), 'param');
        $this->createIndex('category', Settings::tableName(), 'category');

    }

    public function down()
    {
        $this->dropTable(Settings::tableName());
    }

}
