<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'internal_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'page_count') ?>

    <?= $form->field($model, 'isbn') ?>

    <?php // echo $form->field($model, 'issn') ?>

    <?php // echo $form->field($model, 'language_id') ?>

    <?php // echo $form->field($model, 'library_id') ?>

    <?php // echo $form->field($model, 'publisher_id') ?>

    <?php // echo $form->field($model, 'type_id') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'edition') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'last_update') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
