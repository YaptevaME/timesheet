<?php
/* @var $this yii\web\View */

$this->title = 'Сотрудник: Отчет о списаниях рабочего времени за период';
?>
<h1><?= $this->title ?></h1>
<hr>
<div class="report">
    <div class="report-params">
        <div class="report-params-item">
            <label for="param-date-begin">С</label>
            <input type="date" id="param-date-begin" class="form-control">
        </div>
        <div class="report-params-item">
            <label for="param-date-end">По</label>
            <input type="date" id="param-date-end" class="form-control">
        </div>
        <div class="report-params-checkbox">
            <input type="checkbox" id="param-disbalance">
            <label for="param-disbalance">Только дисбаланс</label>
        </div>
        <div class="report-btn-wrap">
            <button class="btn btn-primary" onclick="getResourceReport()">Построить</button>
        </div>
    </div>
    <hr>
    <div class="report-result" id="report-result">
        ajax
    </div>
</div>