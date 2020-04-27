<?php

namespace app\modules\shop\migrations;

/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m190316_061840_shop_insert
 */

use Yii;
use panix\engine\CMS;
use panix\engine\db\Migration;
use app\modules\shop\models\Attribute;
use app\modules\shop\models\AttributeOption;
use app\modules\shop\models\ProductType;
use app\modules\shop\models\Category;
use app\modules\shop\models\Product;
use app\modules\images\models\Image;
use app\modules\shop\models\ProductAttributesEav;
use app\modules\shop\models\ProductCategoryRef;


/**
 * Class m190316_061840_shop_insert
 * @package app\modules\shop\migrations
 */
class m190316_061840_shop_insert extends Migration
{

    public function up()
    {
        $typesList = [1 => 'Основной', 2 => 'Ноутбук'];
        foreach ($typesList as $id => $name) {
            $this->batchInsert(ProductType::tableName(), ['id', 'name'], [
                [$id, $name]
            ]);
        }


        //Add Root Category
        $this->batchInsert(Category::tableName(), ['lft', 'rgt', 'depth', 'name'], [
            [1, 2, 1, 'Каталог продукции']
        ]);


        $categories = [
            [
                'id' => 2,
                'name' => 'Обувь',
                'children' => [
                    ['id' => 4, 'name' => 'Женская'],
                    ['id' => 5, 'name' => 'Мужская'],
                    ['id' => 6, 'name' => 'Детская']
                ]
            ],
            [
                'id' => 3,
                'name' => 'Смартфоны, ТВ и электроника',
                'children' => [
                    ['id' => 7, 'name' => 'Телефоны'],
                    ['id' => 8, 'name' => 'Телевизоры'],
                    ['id' => 9, 'name' => 'Планшеты'],
                    ['id' => 10, 'name' => 'AV-ресиверы'],
                    ['id' => 11, 'name' => 'Акустика Hi-Fi'],
                    ['id' => 12, 'name' => 'Ноутбуки'],
                ]
            ],
        ];

        foreach ($categories as $cat) {
            $parent_id = Category::findModel(1);
            $s = new Category();
            if (isset($cat['id']))
                $s->id = $cat['id'];
            $s->name = $cat['name'];
            $s->appendTo($parent_id);
            if (isset($cat['children'])) {
                foreach ($cat['children'] as $child) {
                    $subCategory = new Category();
                    if (isset($child['id']))
                        $subCategory->id = $child['id'];
                    $subCategory->name = $child['name'];
                    $subCategory->appendTo($s);
                }
            }
        }

    }

    public function down()
    {
        $this->truncateTable(Attribute::tableName());
        $this->truncateTable(AttributeOption::tableName());
        $this->truncateTable(Product::tableName());
        $this->truncateTable(Category::tableName());
        $this->truncateTable(ProductType::tableName());
        $this->truncateTable(ProductCategoryRef::tableName());
        $this->truncateTable(ProductAttributesEav::tableName());
        $this->truncateTable(Image::tableName());

    }

    private function writeAttribute($attribute_id, $value)
    {
        $attributeOption = AttributeOption::find()
            ->where(['value' => $value])
            ->one();
        if (!$attributeOption) {
            $attributeOption = new AttributeOption;
            $attributeOption->attribute_id = $attribute_id;
            $attributeOption->value = $value;
            $attributeOption->save(false);
        }
        return $attributeOption;
    }
}
