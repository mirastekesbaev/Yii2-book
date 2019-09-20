<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "rental".
 *
 * @property string $id
 * @property string $requested_date
 * @property string $user_id
 * @property string $other_detail
 *
 * @property User $user
 * @property RentalBook[] $rentalBooks
 * @property Book[] $books
 */
class Rental extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rental';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requested_date'], 'safe'],
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['other_detail'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'requested_date' => Yii::t('app', 'Requested Date'),
            'user_id' => Yii::t('app', 'User ID'),
            'other_detail' => Yii::t('app', 'Other Detail'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentalBooks()
    {
        return $this->hasMany(RentalBook::className(), ['rental_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id' => 'book_id'])->viaTable('rental_book', ['rental_id' => 'id']);
    }
}
