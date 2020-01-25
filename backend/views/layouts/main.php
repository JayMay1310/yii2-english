<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    } else {
        $menuItems[] = ['label' => 'Добавить слова', 'url' => ['/word/upload']];
        $menuItems[] = ['label' => 'Добавить 1 слово', 'url' => ['/word/create']];
        $menuItems[] = ['label' => 'Статистика', 'url' => ['/word/statistic']];
        $menuItems[] = ['label' => 'Смотреть слова', 'url' => ['/category/index']];
        $menuItems[] = ['label' => 'Для спорта', 'url' => ['/word/sport']];
        //$menuItems[] = '<li>'
        //    . Html::beginForm(['/site/logout'], 'post')
        //    . Html::submitButton(
        //        'Logout (' . Yii::$app->user->identity->username . ')',
        //        ['class' => 'btn btn-link logout']
        //    )
        //    . Html::endForm()
        //    . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="col-sm-3 col-md-2 sidebar">
    <br><br><br><br><br>
          <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="<?= Url::to(['/category/rusty'], true) ?>">>20 дней</a>
                <span class="badge badge-primary badge-pill"><?= Yii::$app->params['count20day']; ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="<?= Url::to(['/category/shortperiod'], true) ?>">>1 дней < 4</a>
                <span class="badge badge-primary badge-pill"><?= Yii::$app->params['onedayfor']; ?></span>
            </li>
          </ul>
          <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="<?= Url::to(['/word/speedlearn'], true) ?>">Скоростное повторение</a>
                <span class="badge badge-primary badge-pill"><?= Yii::$app->params['speedlearn']; ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="<?= Url::to(['/dialog/index'], true) ?>">Dialog</a>
                <span class="badge badge-primary badge-pill">0</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="<?= Url::to(['/word/telegram'], true) ?>">Telegram</a>
                <span class="badge badge-primary badge-pill"><?= Yii::$app->params['telegram']; ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="<?= Url::to(['/link/index'], true) ?>">Link</a>
                <span class="badge badge-primary badge-pill">0</span>
            </li>
          </ul>
    </div>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">

    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
