<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $categoryID
 * @property integer $parent
 * @property string $picture
 * @property integer $sort_order
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'name', 'sort_order'], 'required'],
            [['parent', 'sort_order'], 'integer'],
            [['description'], 'string'],
            [['picture', 'slug', 'name', 'meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryID' => 'Category ID',
            'parent' => 'Parent',
            'picture' => 'Picture',
            'sort_order' => 'Sort Order',
            'slug' => 'Slug',
            'name' => 'Name',
            'description' => 'Description',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
        ];
    }
}
