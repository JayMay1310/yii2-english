<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $categories common\models\Category[] */
$this->title = 'Create Dialog';
$this->params['breadcrumbs'][] = ['label' => 'Dialog', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dialog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>