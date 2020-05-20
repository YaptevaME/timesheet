<?php

use app\models\Department;
use app\models\Employee;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->dropdownList(
        Department::find()->select(['name', 'id'])->indexBy('id')->column(),
        ['prompt' => '...']
    ); ?>

    <?= $form->field($model, 'boss_id')->dropdownList(
        Employee::find()->select(['CONCAT(last_name, " ", first_name)', 'id'])->indexBy('id')->column(),
        ['prompt' => '...']
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>