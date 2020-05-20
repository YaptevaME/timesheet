<?php

/* @var $this yii\web\View */

$this->title = 'Timesheet App';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>TimeSheet</h1>
        <hr>
        <!-- <p><a class="btn btn-lg btn-success" href="/site/login">Вход</a></p> -->
        <?php if (Yii::$app->user->identity->role == 1) : ?>
            <p><a class="btn btn-primary" href="/department">Департаменты</a></p>
            <p><a class="btn btn-primary" href="/position">Должности</a></p>
            <p><a class="btn btn-primary" href="/employee">Сотрудники</a></p>
            <p><a class="btn btn-primary" href="/activity">Активности</a></p>
            <p><a class="btn btn-primary" href="/job">Задачи</a></p>
        <?php elseif (Yii::$app->user->identity->role == 2) : ?>
            <p><a class="btn btn-primary" href="/activity">Активности</a></p>
            <p><a class="btn btn-primary" href="/report/index">Отчёты</a></p>
        <?php elseif (Yii::$app->user->identity->role == 3) : ?>
            <p><a class="btn btn-primary" href="/report/index">Отчёты</a></p>
        <?php elseif (Yii::$app->user->identity->role == 4) : ?>
            <p><a class="btn btn-primary" href="/timesheet/list">Списание времени</a></p>
            <p><a class="btn btn-primary" href="/report/index">Отчёты</a></p>
        <?php endif; ?>
    </div>

</div>