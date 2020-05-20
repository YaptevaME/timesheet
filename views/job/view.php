<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Активности', 'url' => ['/activity/index']];
$this->params['breadcrumbs'][] = ['label' => $model->activity->name, 'url' => ['/activity/view', 'id' => $model->activity_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="job-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Подтверждение удаления',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'begin',
            'end',
            'activity.name',
            'status.name',
        ],
    ]) ?>

</div>
