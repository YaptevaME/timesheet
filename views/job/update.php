<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = 'редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Активности', 'url' => ['/activity/index']];
$this->params['breadcrumbs'][] = ['label' => $model->activity->name, 'url' => ['/activity/view', 'id' => $model->activity_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="job-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
