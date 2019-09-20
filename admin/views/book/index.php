<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\BookSearch */
/* @var $model admin\models\Book */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Books');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(['timeout' => 2000]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Book'), ['create'], ['class' => 'btn btn-success', 'data-pjax' => '0']) ?>

        <?php
        $showDeletedBooks = Yii::$app->getRequest()->getQueryParam(('deleted')) == 'true' ? true : false;
        $params = Yii::$app->getRequest()->getQueryParams();
        if ($showDeletedBooks) {
            unset($params['deleted']);
            //Yii::$app->request->setQueryParams(Yii::$app->request->params);
        }
        echo Html::a(Yii::t('app', $showDeletedBooks ? 'Hide Deleted Books' : 'Show Deleted Books'),
            urldecode(Url::toRoute(array_merge(['index'], ($showDeletedBooks ? [] : ['deleted' => 'true']), $params))),
            ['class' => 'pull-right']) ?>
    </p>

    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => function ($model, $id) {
                    return Html::a($model['name'], Url::to(['book/view', 'id' => $model['id']]));
                },
                'format' => 'html',
                //'search' => true,
            ],
            'isbn',
            'issn',
            [
                'attribute' => 'type_id',
                'label' => Yii::t('app', 'Type'),
                'value' => function ($model) {
                    return Yii::t('app', $model['type']);
                },
            ],
            [
                'attribute' => 'status_id',
                'label' => Yii::t('app', 'Status'),
                'value' => function ($model) {
                    return Yii::t('app', $model['status']);
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {harddelete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::toRoute(['book/' . $action, 'id' => $model['id']]);
                },
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        //hide delete button if book is deleted
                        if ($model['status_id'] === Yii::$app->params['status']['deleted']) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];

                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                    'harddelete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Delete permanently'),
                            'aria-label' => Yii::t('yii', 'Delete permanently'),
                            'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?') . ' ' .
                                Yii::t('app', 'This action can not be undone'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];

                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
