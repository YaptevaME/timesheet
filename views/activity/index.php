<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Активности';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <table class="table table-hover">
        <?php foreach ($activities as $no => $ac) : ?>
            <tr ondblclick="window.location.href = '/activity/view?id=<?= $ac->id ?>'">
                <td><?= ++$no ?></td>
                <td><?= $ac->name ?></td>
                <td><?= $ac->code ?></td>
                <td><?= $ac->activityType->name ?></td>
                <td><?= $ac->manager->last_name . ' ' . $ac->manager->first_name ?></td>
                <td><?= $ac->status->name ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?php
    // echo GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     'filterModel' => $searchModel,
    //     'columns' => [
    //         ['class' => 'yii\grid\SerialColumn'],

    //         // 'id',
    //         'name',
    //         'code',
    //         'status.name',
    //         'activityType.name',
    //         //'manager_id',

    //         ['class' => 'yii\grid\ActionColumn'],
    //     ],
    // ]); 
    ?>


</div>