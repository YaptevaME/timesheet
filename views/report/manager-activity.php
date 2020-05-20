<?php
/* @var $this yii\web\View */

$this->title = 'Менеджер: отчёт по активности';
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
            <label for="param-activity">Активность</label>
            <select id="param-activity" class="form-control">
                <option disabled selected></option>
                <?php foreach ($activities as $activity) : ?>
                    <option value="<?= $activity->id ?>"><?= $activity->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="report-params-checkbox">
            <input type="checkbox" id="param-details">
            <label for="param-details">С детализацией по задачам</label>
        </div>
        <div class="report-btn-wrap">
            <button class="btn btn-primary" onclick="getManagerActivityReport()">Построить</button>
        </div>
    </div>
    <hr>
    <div class="report-result" id="report-result">
        ajax
    </div>
</div>