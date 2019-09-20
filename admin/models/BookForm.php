<?php

namespace admin\models;

use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * model class for book's CRUD functions
 * @property Book $modelBook
 */
class BookForm
{
    public $modelBook;

    /**
     * @param $modelBook
     */
    function __construct(&$modelBook)
    {
        $this->modelBook = $modelBook;
    }

    /**
     * @return array
     */
    /*public static function getLanguageNameList()
    {
        $language = Language::find()->select(['id', 'name'])->asArray()->all();
        return ArrayHelper::map($language, 'id', 'name');
    }*/

    /**
     * create key-value array from entered class name
     * (for drop down list)
     *
     * @param $class -  name class => table
     * @param $key - column from table
     * @param $value - column from table
     * @return array
     */
    public static function createArrayMap($class, $key, $value)
    {
        $d = $class::find()->select([$key, $value])->orderBy([$value => SORT_ASC])->asArray()->all();
        $map = ArrayHelper::map($d, $key, $value);
        unset($d);

        return $map;
    }

    /**
     * Translate a value from key-value array
     * @param $class -  name class => table
     * @param $key - column from table
     * @param $value - column from table
     * @return array
     */
    public static function createArrayMapTranslate($class, $key, $value)
    {
        $map = self::createArrayMap($class, $key, $value);
        foreach ($map as &$m) {
            $m = \Yii::t('app', $m);
        }

        return $map;
    }

    /**
     * get all key words assigned to book
     * @return string - key words imploded with comma
     */
    public function getKeyWords()
    {
        $keyW = $this->modelBook->getKeyWords()->orderBy(['word' => SORT_ASC])->asArray()->all();
        $keyWords = [];
        foreach ($keyW as $kw) {
            $keyWords[] = $kw['word'];
        }

        return implode(', ', $keyWords);
    }

    /**
     * get all Book's Author
     * @return string - with all authors imploded with comma
     */
    public function getAuthors()
    {
        $authors = $this->modelBook->getAuthors()->orderBy(['last_name' => SORT_ASC])->asArray()->all();
        $allAuthors = [];
        foreach ($authors as $a) {
            $allAuthors[] = $a['first_name'] . ' ' . $a['last_name'];
        }

        return implode(', ', $allAuthors);
    }

    /**
     * explode all key words separated by comma and create array for creating and loading
     * multiple KeyWord models
     * @param $keyString
     * @return array|bool - array if
     */
    public function prepareKeyWords($keyString)
    {
        if (empty($keyString)) {
            return false;
        }
        $wordsArray = [];
        $words = explode(',', $keyString);
        foreach ($words as $word) {
            //$word = strip_tags($word);
            if (!empty($word)) {
                $wordsArray[] = ['word' => $word];
            }
        }

        return empty($wordsArray) ? false : $wordsArray;
    }

    /**
     * create record of book with all related parameters
     * already existing Author model is linked with book otherwise new Author model is created and linked,
     * the same with KeyWord model
     * - if author or key word already exist new book is assigned to him, if not they are created
     * - transaction is for consistent data (book, authors, key words)
     *
     * @param $modelsAuthor - reference to Author model
     * @param $modelsKeyWords - reference to KeyWord model
     * @var $modelAuthor Author
     * @return bool - if creation si successful, otherwise false
     * @throws \yii\db\Exception
     */
    public function createBook(&$modelsAuthor, &$modelsKeyWords)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->modelBook->save(false)) {

                $this->createBookInternalId();
                $this->modelBook->update(false);

                //save authors
                foreach ($modelsAuthor as $modelAuthor) {
                    if (($existA = Author::findOne([
                            'first_name' => $modelAuthor->first_name,
                            'last_name' => $modelAuthor->last_name
                        ])) !== null
                    ) {
                        $this->modelBook->link('authors', $existA);
                    } else {
                        if (!($flag = $modelAuthor->save(false))) {
                            throw new Exception("Failed save new Authors in create Book model action.");
                        }
                        //link tables
                        $this->modelBook->link('authors', $modelAuthor);
                    }
                }
                //save keys
                if ($flag) {
                    foreach ($modelsKeyWords as $modelKeyWord) {
                        if (($existKey = KeyWord::findOne(['word' => $modelKeyWord->word])) !== null) {
                            $this->modelBook->link('keyWords', $existKey);
                        } else {
                            if (!($flag = $modelKeyWord->save(false))) {
                                throw new Exception("Failed save key words in create book action.");
                            }
                            //link tables
                            $this->modelBook->link('keyWords', $modelKeyWord);
                        }
                    }
                }
            }
            if ($flag) {
                $transaction->commit();

                return true;
            }
        } catch (\Exception $e) {
            \Yii::warning($e->getMessage());
            $transaction->rollBack();

            return false;
        }

        return false;
    }

    /**
     * update book and all related parameters
     * if unchanged Author already exist do nothing, otherwise delete all old authors and create new
     * the same with KeyWord-s
     * - if author or key word already exist new book is assigned to him, if not they are created
     * - transaction is for consistent data (book, authors, key words)
     *
     * @param Author[] $modelsAuthor
     * @param Author[] $modelsAuthorNew
     * @var KeyWord[] $modelsKeyWordsNew
     * @return bool - true if transaction(update) is successful otherwise false
     * @throws \yii\db\Exception
     */
    public function updateBook($modelsAuthor, &$modelsAuthorNew, &$modelsKeyWordsNew)
    {
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            if ($flag = $this->modelBook->save(false)) {

                //Authors - filter unchanged Authors
                foreach ($modelsAuthorNew as $authorNewKey => $authorNew) {
                    foreach ($modelsAuthor as $authorKey => $author) {
                        if ($authorNew->first_name === $author->first_name && $authorNew->last_name === $author->last_name) {
                            unset($modelsAuthorNew[$authorNewKey], $modelsAuthor[$authorKey]);
                        }
                    }
                }
                //delete all unused (old) Authors(link table record), if model Author is the last one, delete Author itself too
                foreach ($modelsAuthor as $ma) {
                    $maid = $ma->id;
                    if (($count = $db->createCommand('SELECT COUNT(*) FROM book_author WHERE author_id = :author_id')->bindParam(':author_id',
                            $maid)->queryScalar()) !== false
                    ) {
                        $db->createCommand()->delete('book_author',
                            ['author_id' => $ma->id, 'book_id' => $this->modelBook->id])->execute();
                        if ($count == 1) {
                            $ma->delete();
                        }
                    }
                }
                //add new Authors
                foreach ($modelsAuthorNew as $authorNew) {
                    if (($existA = Author::findOne([
                            'first_name' => $authorNew->first_name,
                            'last_name' => $authorNew->last_name
                        ])) !== null
                    ) {
                        $this->modelBook->link('authors', $existA);
                    } else {
                        if (!($flag = $authorNew->save(false))) {
                            throw new Exception("Failed save new Authors in update book model action.");
                        }
                        $this->modelBook->link('authors', $authorNew);
                    }
                }

                //KeyWords - filter unchanged words
                $keyWordIds = $this->modelBook->getKeyWords()->select('id')->asArray()->all();
                $modelsKeyWords = KeyWord::findAll($keyWordIds);
                foreach ($modelsKeyWordsNew as $keyWordNewKey => $keyWordNew) {
                    foreach ($modelsKeyWords as $keyWordKey => $keyWord) {
                        if ($keyWordNew->word === $keyWord->word) {
                            unset($modelsKeyWordsNew[$keyWordNewKey], $modelsKeyWords[$keyWordKey]);
                        }
                    }
                }
                //delete all old KeyWords
                foreach ($modelsKeyWords as $mkw) {
                    $mkwid = $mkw->id;
                    if (($count = $db->createCommand('SELECT COUNT(*) FROM book_key_word WHERE key_word_id = :key_word_id')->bindParam(':key_word_id',
                            $mkwid)->queryScalar()) !== false
                    ) {
                        $db->createCommand()->delete('book_key_word',
                            ['key_word_id' => $mkw->id, 'book_id' => $this->modelBook->id])->execute();
                        if ($count == 1) {
                            $mkw->delete();
                        }
                    }
                }
                //save new keys
                if ($flag) {
                    foreach ($modelsKeyWordsNew as $keyWordNew) {
                        if (($existKey = KeyWord::findOne(['word' => $keyWordNew->word])) !== null) {
                            $this->modelBook->link('keyWords', $existKey);
                        } else {
                            if (!($flag = $keyWordNew->save(false))) {
                                throw new Exception("Failed save key words in update book action.");
                            }
                            $this->modelBook->link('keyWords', $keyWordNew);
                        }
                    }
                }

            }
            if ($flag) {
                $transaction->commit();

                return true;
            }

        } catch (\Exception $e) {
            \Yii::warning($e->getMessage());
            $transaction->rollBack();

            return false;
        }

        return false;
    }

    /**
     * create internal Book ID, format: padded book id to a length 11 with 0, "0000000022"
     */
    public function createBookInternalId()
    {
        $this->modelBook->internal_id = str_pad($this->modelBook->id, 11, '0', STR_PAD_LEFT);
    }

    /**
     * hard delete - delete all book data and related authors, keywords, logs, rentals, payments
     * - entry (row) in tables: log_book, rental_book, payment FK-s referenced to book table are cascade deleted
     *      On Delete: CASCADE
     *
     * @return bool - true if transaction (delete) is successful otherwise false
     * @throws \yii\db\Exception
     */
    public function deleteBook()
    {
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {

            //delete all related authors with only one book = this book
            $allAuthors = $this->modelBook->getAuthors()->select('id')->asArray()->all();
            foreach ($allAuthors as $aa) {
                if (($count = $db->createCommand('SELECT COUNT(*) FROM book_author WHERE author_id = :author_id')->bindParam(':author_id',
                        $aa['id'])->queryScalar()) !== false
                ) {
                    $db->createCommand()->delete('book_author',
                        ['author_id' => $aa['id'], 'book_id' => $this->modelBook->id])->execute();
                    if ($count == 1) {
                        $db->createCommand()->delete('author', ['id' => $aa['id']])->execute();
                    }
                }
            }
            $allKWords = $this->modelBook->getKeyWords()->select('id')->asArray()->all();
            foreach ($allKWords as $kw) {
                if (($count = $db->createCommand('SELECT COUNT(*) FROM book_key_word WHERE key_word_id = :key_word_id')->bindParam(':key_word_id',
                        $kw['id'])->queryScalar()) !== false
                ) {
                    $db->createCommand()->delete('book_key_word',
                        ['key_word_id' => $kw['id'], 'book_id' => $this->modelBook->id])->execute();
                    if ($count == 1) {
                        $db->createCommand()->delete('key_word', ['id' => $kw['id']])->execute();
                    }
                }
            }

            $this->modelBook->delete();
            $transaction->commit();
        } catch (\Exception $e) {
            \Yii::warning($e->getMessage());
            $transaction->rollBack();

            return false;
        }

        return true;
    }

    /**
     * get list of all errors of model Book in actionUpdate
     *
     * @param $modelsArray
     * @return bool|string
     */
    public static function getErrorsMessages(&$modelsArray)
    {
        $messages = '';
        foreach ($modelsArray as $model) {
            if ($model->hasErrors()) {
                $errors = $model->getErrors();
                foreach ($errors as $attrErrors) {
                    $messages .= implode(', <br>', $attrErrors) . '<br>';
                }
            }
        }

        return $messages === '' ? false : $messages;
    }
}
