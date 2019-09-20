<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelBook admin\models\Book */

$this->title = $modelBook->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="pull-left">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $modelBook->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Back'), Yii::$app->request->referrer ? Yii::$app->request->referrer : ['index'],
            ['class' => 'btn btn-default']) ?>
    </div>
    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelBook->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Delete permanently'), ['harddelete', 'id' => $modelBook->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?') . ' ' .
                    Yii::t('app', 'This action can not be undone'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <br><br><br>

    <table class="table table-striped table-bordered detail-view">
        <tr>
            <th><?= Yii::t('app', 'Book name') ?></th>
            <td><?= Html::encode($modelBook->name) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Author') ?></th>
            <td><?= Html::encode($authors) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Internal ID') ?></th>
            <td><?= Html::encode($modelBook->internal_id) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'ISBN') ?></th>
            <td><?= Html::encode($modelBook->isbn) ?></td>
        </tr>
        <?php if (!empty($modelBook->issn)) { ?>
            <tr>
                <th><?= Yii::t('app', 'ISSN') ?></th>
                <td><?= Html::encode($modelBook->issn) ?></td>
            </tr>
        <?php } ?>
        <tr>
            <th><?= Yii::t('app', 'Pages') ?></th>
            <td><?= Html::encode($modelBook->page_count) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Language') ?></th>
            <td><?= $modelBook->language->name ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Publisher') ?></th>
            <td><?= Html::encode($modelBook->publisher->name) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Type') ?></th>
            <td><?= Yii::t('app', $modelBook->type->type) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Status') ?></th>
            <td><?= Yii::t('app', $modelBook->status->status) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Category') ?></th>
            <td><?= isset($modelBook->category) ? Html::encode($modelBook->category->category_name) : '' ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Edition') ?></th>
            <td><?= Html::encode($modelBook->edition) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Year') ?></th>
            <td><?= Html::encode($modelBook->year) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Key Words') ?></th>
            <td><?= Html::encode($keyWords) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Description') ?></th>
            <td><?= Html::encode($modelBook->description) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('app', 'Last update') ?></th>
            <td><?= Yii::$app->formatter->asDatetime($modelBook->updated_at) ?></td>
        </tr>
    </table>
</div>
