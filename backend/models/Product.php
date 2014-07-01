<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "products".
 *
 * @property integer $productID
 * @property integer $categoryID
 * @property double $Price
 * @property integer $in_stock
 * @property integer $enabled
 * @property string $product_code
 * @property integer $sort_order
 * @property integer $default_picture
 * @property string $date_added
 * @property string $date_modified
 * @property string $slug
 * @property string $name
 * @property string $brief_description
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }
	
	public function behaviors()
	{
		return [
			'timestampBehavior' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['date_added', 'date_modified'],
					ActiveRecord::EVENT_BEFORE_UPDATE => 'date_modified',
				],
				'value' => new Expression('NOW()'),
			],
		];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoryID', 'in_stock', 'enabled', 'sort_order', 'default_picture'], 'integer'],
            [['Price'], 'number'],
            [['date_added', 'date_modified'], 'safe'],
            [['brief_description', 'description'], 'string'],
            [['product_code'], 'string', 'max' => 25],
            [['slug', 'name', 'meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productID' => 'Product ID',
            'categoryID' => 'Category ID',
            'Price' => 'Price',
            'in_stock' => 'In Stock',
            'enabled' => 'Enabled',
            'product_code' => 'Product Code',
            'sort_order' => 'Sort Order',
            'default_picture' => 'Default Picture',
            'date_added' => 'Date Added',
            'date_modified' => 'Date Modified',
            'slug' => 'Slug',
            'name' => 'Name',
            'brief_description' => 'Brief Description',
            'description' => 'Description',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
        ];
    }

}
