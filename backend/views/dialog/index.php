<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Dialog';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dialog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id', 'title',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create} {view} {update} {delete} {speed-category-learn}',
                'buttons' => [
                    'create' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['dialog/create-dialog', 'id' => $model->id]);
                    },
                    'speed-category-learn' => function ($url, $model, $key) {
                        return Html::a('Speed', $url);
                    },
                ],
            ], 'last_update'
        ],
    ]); ?>

</div>