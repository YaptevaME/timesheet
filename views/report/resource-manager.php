<?php
/* @var $this yii\web\View */

$this->title = 'Ресурс-менеджер: отчёт по сотрудникам';
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
        <div class="report-params-item">
            <label for="param-balance">Параметр отображения</label>
            <select id="param-balance" class="form-control">
                <option value="0" selected>Все сотрудники</option>
                <option value="1">Положительный дисбаланс</option>
                <option value="2">Отрицательный дисбаланс</option>
            </select>
        </div>
        <div class="report-btn-wrap">
            <button class="btn btn-primary" onclick="getResourceManagerReport()">Построить</button>
        </div>
    </div>
    <hr>
    <div class="report-result" id="report-result">
        ajax
    </div>
</div>