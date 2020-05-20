<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>

<body>
  <?php $this->beginBody() ?>
  <div class="timesheet-wrap">

    <div class="timesheet">
      <?php
      NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
          'class' => 'navbar-inverse navbar-fixed-top',
        ],
      ]);
      echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
          // ['label' => 'Home', 'url' => ['/site/index']],
          // ['label' => 'Contact', 'url' => ['/site/contact']],
          Yii::$app->user->isGuest ? (['label' => 'Login', 'url' => ['/site/login']]) : ('<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
              'Logout (' . Yii::$app->user->identity->login . ')',
              ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>')
        ],
      ]);
      NavBar::end();
      ?>

      <div class="container">
        <?= Breadcrumbs::widget([
          'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
      </div>
    </div>
  </div>

  <footer>
    &copy; YaptevaME <?= date('Y') ?>
  </footer>

  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>

<!-- Триггер кнопка модали-->
<!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#timesheetModal">
  Launch demo modal
</button> -->

<!-- Модаль -->
<div class="modal fade" id="timesheetModal" tabindex="-1" role="dialog" aria-labelledby="timesheetModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="timesheetModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>