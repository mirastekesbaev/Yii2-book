<?php

namespace admin\models;

use Isbn\Isbn;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "book".
 *
 * @property string $id
 * @property string $internal_id
 * @property string $name
 * @property integer $page_count
 * @property string $isbn
 * @property string $issn
 * @property integer $language_id
 * @property string $library_id
 * @property string $publisher_id
 * @property integer $type_id
 * @property integer $status_id
 * @property integer $category_id
 * @property integer $edition
 * @property integer $year
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 * @property Language $language
 * @property Library $library
 * @property Publisher $publisher
 * @property Status $status
 * @property Type $type
 * @property BookAuthor[] $bookAuthors
 * @property Author[] $authors
 * @property BookKeyWord[] $bookKeyWords
 * @property KeyWord[] $keyWords
 * @property LogCrud[] $logCruds
 * @property RentalBook[] $rentalBooks
 * @property Rental[] $rentals
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * Validation rules
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'internal_id',
                    'name',
                    'language_id',
                    'library_id',
                    'publisher_id',
                    'type_id',
                    'status_id',
                    'category_id'
                ],
                'required'
            ],
            [
                [
                    'page_count',
                    'language_id',
                    'library_id',
                    'publisher_id',
                    'type_id',
                    'status_id',
                    'category_id',
                    'edition',
                    'year'
                ],
                'integer'
            ],
            [['description'], 'string'],
            [['description'], 'stripTags'],
            [['updated_at', 'created_at'], 'safe'],
            [['internal_id'], 'string', 'max' => 11],
            [['name'], 'string', 'max' => 255],
            [['isbn', 'issn'], 'string', 'max' => 20],
            [['isbn', 'issn'], 'validateISBN'],
            [['internal_id'], 'unique'],
            [['year'], 'integer', 'max' => 2999, 'min' => 1900],
        ];
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
     * strip HTML and php tags
     * @return string
     */
    public function stripTags()
    {
        return strip_tags($this->description);
    }

    /**
     * Validate correct ISBN/ISSN format
     */
    public function validateISBN()
    {
        $isbn = new Isbn();
        if (!empty($this->isbn)) {
            if ($isbn->validation->isbn($this->isbn) === false) {
                $this->addError('isbn', Yii::t('app', 'Not valid {isbn}', ['isbn' => 'isbn']));
            } else {
                $this->isbn = $isbn->hyphens->fixHyphens($this->isbn);
            }
        }
        if (!empty($this->issn)) {
            if ($isbn->validation->isbn($this->issn) === false) {
                $this->addError('issn', Yii::t('app', 'Not valid {isbn}', ['isbn' => 'issn']));
            } else {
                $this->issn = $isbn->hyphens->fixHyphens($this->issn);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'internal_id' => Yii::t('app', 'Internal ID'),
            'name' => Yii::t('app', 'Book name'),
            'page_count' => Yii::t('app', 'Page Count'),
            'isbn' => Yii::t('app', 'Isbn'),
            'issn' => Yii::t('app', 'Issn'),
            'language_id' => Yii::t('app', 'Language'),
            'library_id' => Yii::t('app', 'Library'),
            'publisher_id' => Yii::t('app', 'Publisher'),
            'type_id' => Yii::t('app', 'Type'),
            'status_id' => Yii::t('app', 'Status'),
            'category_id' => Yii::t('app', 'Category'),
            'edition' => Yii::t('app', 'Edition'),
            'year' => Yii::t('app', 'Year'),
            'description' => Yii::t('app', 'Description'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /*public function getCategoryName()
    {
        return $this->getCategory()->asArray()->one()['category_name'];
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    public function getLanguageName()
    {
        return $this->getLanguage()->asArray()->one()['name'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibrary()
    {
        return $this->hasOne(Library::className(), ['id' => 'library_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublisher()
    {
        return $this->hasOne(Publisher::className(), ['id' => 'publisher_id']);
    }

    public function getPublisherName()
    {
        return $this->getPublisher()->asArray()->one()['name'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    public function getStatusName()
    {
        return Yii::t('app', $this->getStatus()->asArray()->one()['status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    /*public function getTypeName()
    {
        return Yii::t('app', $this->getType()->asArray()->one()['type']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAutho::className(), ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::className(), ['id' => 'author_id'])->viaTable('book_author', ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookKeyWords()
    {
        return $this->hasMany(BookKeyWord::className(), ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKeyWords()
    {
        return $this->hasMany(KeyWord::className(), ['id' => 'key_word_id'])->viaTable('book_key_word',
            ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentalBooks()
    {
        return $this->hasMany(RentalBook::className(), ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentals()
    {
        return $this->hasMany(Rental::className(), ['id' => 'rental_id'])->viaTable('rental_book', ['book_id' => 'id']);
    }
}
