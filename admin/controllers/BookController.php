<?php

namespace admin\controllers;

use admin\models\Author;
use admin\models\Book;
use admin\models\BookForm;
use admin\models\BookSearch;
use admin\models\KeyWord;
use admin\models\Model;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'view', 'create', 'update', 'delete', 'harddelete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'harddelete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $modelBook = $this->findModel($id);
        $modelBookForm = new BookForm($modelBook);

        return $this->render('view', [
            'modelBook' => $modelBook,
            'authors' => $modelBookForm->getAuthors(),
            'keyWords' => $modelBookForm->getKeyWords(),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelBook = new Book;
        $modelBookForm = new BookForm($modelBook);
        $modelsAuthor = [new Author];
        $modelsKeyWords = [new KeyWord];

        if ($modelBook->load(Yii::$app->request->post())) {
            $modelsAuthor = Model::createMultiple(Author::className());
            Model::loadMultiple($modelsAuthor, Yii::$app->request->post());
            //process, separate book keyWords
            if ($wordsArray = $modelBookForm->prepareKeyWords(Yii::$app->request->post('KeyWord')['words'])) {
                $modelsKeyWords = Model::createMultiple(KeyWord::className(), [], $wordsArray);
                // KeyWord[0]['word' =>'php']
                Model::loadMultiple($modelsKeyWords, $wordsArray, '');
            }

            //before validation we need insert fake internal_id
            $modelBook->internal_id = '00000000000';
            // validate all models
            $valid = $modelBook->validate();
            $valid = Model::validateMultiple($modelsAuthor) && $valid;
            $valid = $wordsArray === false ? $valid : Model::validateMultiple($modelsKeyWords) && $valid;

            if ($valid && $modelBookForm->createBook($modelsAuthor, $modelsKeyWords)) {
                Yii::info($modelBook->id . '_create', 'book');
                $this->redirect(['view', 'id' => $modelBook->id]);
            }
        }

        return $this->render('create', [
            'modelBook' => $modelBook,
            'modelsAuthor' => (empty($modelsAuthor)) ? [new Author] : $modelsAuthor,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @var Author[] $modelsAuthorNew
     * @param string $id Book id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelBook = $this->findModel($id);
        $modelBookForm = new BookForm($modelBook);
        $authorsId = $modelBook->getAuthors()->select('id')->asArray()->all();
        $modelsAuthor = Author::findAll($authorsId); //$modelBook->getAuthors()->asArray()->all();

        if ($modelBook->load(Yii::$app->request->post())) {
            $modelsAuthorNew = Model::createMultiple(Author::className());
            Model::loadMultiple($modelsAuthorNew, Yii::$app->request->post());
            //process, separate book keyWords
            $modelsKeyWordsNew = [new KeyWord];
            if ($wordsArray = $modelBookForm->prepareKeyWords(Yii::$app->request->post('KeyWord')['words'])) {
                $modelsKeyWordsNew = Model::createMultiple(KeyWord::className(), [], $wordsArray);
                // KeyWord[0]['word' =>'php']
                Model::loadMultiple($modelsKeyWordsNew, $wordsArray, '');
            }
            $valid = $modelBook->validate();
            $valid = Model::validateMultiple($modelsAuthorNew) && $valid;
            $valid = $wordsArray === false ? $valid : Model::validateMultiple($modelsKeyWordsNew) && $valid;

            if ($valid && $modelBookForm->updateBook($modelsAuthor, $modelsAuthorNew, $modelsKeyWordsNew)) {
                Yii::$app->session->setFlash('success', Yii::t('app', Yii::t('app', 'Book was updated successfully.')));
                Yii::info($id . '_update', 'book');

                return $this->redirect(['view', 'id' => $modelBook->id]);
            } else {
                //get all errors from multiple models
                if (($msg = BookForm::getErrorsMessages($modelsAuthorNew)) !== false) {
                    Yii::$app->session->addFlash('danger', $msg);
                }
                if (($msg = BookForm::getErrorsMessages($modelsKeyWordsNew)) !== false) {
                    Yii::$app->session->addFlash('danger', $msg);
                }
            }
            Yii::$app->session->addFlash('danger', Yii::t('app', 'Book was not updated.'));
        }

        return $this->render('update', [
            'modelBook' => $modelBook,
            'modelsAuthor' => (empty($modelsAuthor)) ? [new Author] : $modelsAuthor,
            'keyWords' => $modelBookForm->getKeyWords(),
        ]);
    }

    /**
     * Deletes an existing Book model changing book status to deleted.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $book = $this->findModel($id);
        $book->status_id = Yii::$app->params['status']['deleted'];
        $book->update(false);
        Yii::info($id . '_delete', 'book');
        Yii::$app->session->addFlash('success', Yii::t('app', 'Book was deleted successfully.'));

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Book model and all related data.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionHarddelete($id)
    {
        $modelBook = $this->findModel($id);
        $modelBookForm = new BookForm($modelBook);
        if ($modelBookForm->deleteBook()) {
            Yii::info($id . '_harddelete', 'book');
            Yii::$app->session->addFlash('success', Yii::t('app', 'Book was deleted successfully.'));

            return $this->redirect(['index']);
        }
        Yii::$app->session->addFlash('danger', Yii::t('app', 'Book was not deleted.'));

        return $this->redirect(['view', 'id' => $modelBook->id]);

    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}

