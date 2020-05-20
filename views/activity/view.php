<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Активности', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="activity-view">

    <h1><?= Html::encode($this->title) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Подтверждение удаления',
                'method' => 'post',
            ],
        ]) ?>
    </h1>

    <h3>Задачи</h3>
    <p><a class="btn btn-primary" href="/job/create?activity_id=<?= $model->id ?>">Добавить задачу</a></p>
    <table class="table table-hover">
        <?php foreach ($jobs as $no => $job) : ?>
            <tr ondblclick="window.location.href = '/job/view?id=<?= $job->id ?>'">
                <td><?= ++$no ?></td>
                <td><?= $job->name ?></td>
                <td><?= $job->begin ?></td>
                <td><?= $job->end ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($model->activity_type_id !== 1) : ?>
        <h3>Сотрудники</h3>
        <p><button class="btn btn-primary" onclick="addEmployee(<?= $model->id ?>)" data-toggle="modal" data-target="#timesheetModal">Добавить</button></p>

        <table class="table table-hover">
            <?php foreach ($employees as $no => $employee) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $employee->last_name ?> <?= $employee->first_name ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>