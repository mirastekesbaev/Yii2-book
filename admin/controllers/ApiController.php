<?php
namespace admin\controllers;

use admin\models\Book;
use yii\rest\ActiveController;
use yii\web\Response;

class ApiController extends ActiveController
{
    public $modelClass = 'admin\models\Book';

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
        ];
    }



    public function beforeAction($event)
    {
        return parent::beforeAction($event);
    }

    /**
     * @api {get} /news Список новостей
     * @apiVersion 3.0.0
     * @apiName Index
     * @apiGroup News
     *
     * @apiParam {Number} page Страница
     *
     * @apiSuccess {Boolean}    success     Результат
     * @apiSuccess {String}     response    Текст ошибки, если новости не найдены
     * @apiSuccess {Object[]}   data        Список новостей
     * @apiSuccess {Number}     data.news_id    ID новости
     * @apiSuccess {String}     data.title    Заголовок новости
     * @apiSuccess {String}     data.summary    Краткое описание новости
     * @apiSuccess {String}     data.html   HTML-страница с новостью
     * @apiSuccess {String}     data.created_at   Дата создания в формате d.m.Y
     * @apiSuccess {String}     data.thumbUrl   Ссылка на изображение
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": true,
     *       "data": [
     *          {
     *              "news_id": 34,
     *              "title": "test title",
     *              "summary": "test summary",
     *              "html": "&lt;!DOCTYPE html&gt;...&lt;/html&gt;\n",
     *              "created_at": "07.02.2017",
     *              "thumbUrl": "//static.dev.marden.kz/redactor_files/news/29/thumbs/3e850c2596cad544e788b87d2f509da8.png"
     *          },
     *          ...
     *       ]
     *     }
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": false,
     *       "response": "Информация не найдена."
     *     }
     */
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $page = intval(Yii::$app->request->get('page', 1));
        $limit = 20;
        $offset = $limit * ($page - 1);

        $items = Book::find()
            ->joinWith(['content' => function($query){
                $query->andWhere(['not', ['title' => null]]);
            }])
            ->where(['status_id' => 1])
            ->offset($offset)
            ->limit($limit)
            ->orderBy([
                'created_at' => SORT_DESC,
                'news.id' => SORT_DESC,
            ])
            ->all();

        if (empty($items)) {
            return [
                'success' => false,
                'response' => $page == 1 ? 'Новостей пока нет' : 'Показаны все новости',
            ];
        }

        return [
            'success' => true,
            'data' => $items,
        ];
    }
}