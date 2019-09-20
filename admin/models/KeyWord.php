<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "key_word".
 *
 * @property string $id
 * @property string $word
 * @property string $updated_at
 * @property string $created_at
 *
 * @property BookKeyWord[] $bookKeyWords
 * @property Book[] $books
 */
class KeyWord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'key_word';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['word', 'trim'],
            ['word', 'stripTags'],
            [['word'], 'required'],
            [['updated_at', 'created_at'], 'safe'],
            [['word'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'word' => Yii::t('app', 'Key Words'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * strip HTML and php tags
     * @return string
     */
    public function stripTags()
    {
        return strip_tags($this->word);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookKeyWords()
    {
        return $this->hasMany(BookKeyWord::className(), ['key_word_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id' => 'book_id'])->viaTable('book_key_word', ['key_word_id' => 'id']);
    }
}
