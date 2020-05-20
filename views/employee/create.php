<?php

use app\models\Department;
use app\models\Employee;
use app\models\Position;
use app\models\Role;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = 'Новый сотрудник';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (count($errors) > 0) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="employee-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'no')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'position_id')->dropdownList(
            Position::find()->select(['name', 'id'])->indexBy('id')->column(),
            ['prompt' => '...']
        ); ?>

        <?= $form->field($model, 'is_active')->checkbox() ?>

        <?= $form->field($model, 'department_id')->dropdownList(
            Department::find()->select(['name', 'id'])->indexBy('id')->column(),
            ['prompt' => '...']
        ); ?>

        <?= $form->field($model, 'manager_id')->dropdownList(
            Employee::find()->select(['CONCAT(last_name, " ", first_name)', 'id'])->indexBy('id')->column(),
            ['prompt' => '...']
        ); ?>

        <?= $form->field($model, 'timenorm')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'role_id')->dropdownList(
            Role::find()->select(['name', 'id'])->indexBy('id')->column(),
            ['prompt' => '...']
        ); ?>

        <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'confirm_password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>