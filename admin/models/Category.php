<?php

namespace admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $category_name
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted
 *
 * @property Book[] $books
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),

            ],
        ];
    }

    /**
     * Validation rules
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name'], 'required'],
            [['updated_at', 'created_at', 'deleted'], 'safe'],
            [['category_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return parent::find()->where([self::tableName() . '.deleted' => null]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_name' => Yii::t('app', 'Category Name'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['category_id' => 'id']);
    }
}
