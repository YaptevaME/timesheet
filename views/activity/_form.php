<?php

use app\models\ActivityType;
use app\models\Employee;
use app\models\Status;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->dropdownList(
        Status::find()->select(['name', 'id'])->indexBy('id')->column(),
        ['prompt' => '...']
    ); ?>

    <?= $form->field($model, 'activity_type_id')->dropdownList(
        ActivityType::find()->select(['name', 'id'])->indexBy('id')->column(),
        ['prompt' => '...']
    ); ?>

    <?= $form->field($model, 'manager_id')->dropdownList(
        Employee::find()->where(['role_id' => 2])->select(['CONCAT(last_name, " ", first_name)', 'id'])->indexBy('id')->column(),
        ['prompt' => '...']
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>