<?php

use app\models\Employee;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="timesheetModalLabel">Добавление сотрудника</h4>
</div>
<div class="modal-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->dropdownList(
        Employee::find()->select(['CONCAT(last_name, " ", first_name)', 'id'])->indexBy('id')->column(),
        ['prompt' => '...']
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<div class="add-employee">
</div>