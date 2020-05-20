<?php

use app\models\Activity;
use app\models\Status;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Job */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'begin')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'end')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'activity_id')->dropdownList(
        Activity::find()->select(['name', 'id'])->indexBy('id')->column(),
        ['prompt' => '...']
    ); ?>

    <?= $form->field($model, 'status_id')->dropdownList(
        Status::find()->select(['name', 'id'])->indexBy('id')->column(),
        ['prompt' => '...']
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
