<?php
/* @var $this yii\web\View */

$this->title = 'Отчёты';
?>
<h1><?= $this->title ?></h1>

<div class="report-list">
    <?php if (Yii::$app->user->identity->role == 2) : ?>
        <a href="/report/manager-activity">
            <div class="report-item text-center">По активности</div>
        </a>
    <?php elseif (Yii::$app->user->identity->role == 3) : ?>
        <a href="/report/resource-manager">
            <div class="report-item text-center">По ресурсной группе</div>
        </a>
    <?php elseif (Yii::$app->user->identity->role == 4) : ?>
        <a href="/report/resource">
            <div class="report-item text-center">Отчёт по списаниям времени за период</div>
        </a>
    <?php endif; ?>

</div>