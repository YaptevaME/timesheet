<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\TimesheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Списание времени';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timesheet-index">
    <h1><?= $this->title ?></h1>
    <hr>
    <?php if (count($notifications) > 0) : ?>
        <div class="alert-wrap">
            <div class="alert alert-warning">
                Имеется положительный дисбаланс списаний рабочего времени!
                <button class="btn btn-warning" type="button" onclick="readMessage()">Прочитано!</button>
            </div>
            <hr>
        </div>
    <?php endif; ?>
    <div class="select-wrap">
        <div class="select-week-wrap">
            <input type="week" id="timesheet-week" class="form-control" value="<?= date('Y') ?>-W<?= $current_week ?>" oninput="loadWeekDays()">
        </div>
        <hr>
    </div>
    <div class="timesheet-week" id="weekdays">

    </div>
</div>

<script>
    loadWeekDays();
</script>