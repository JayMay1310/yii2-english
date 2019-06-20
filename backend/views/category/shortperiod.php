<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->registerJs(
    "$('input[type=\"checkbox\"]').click(function(){

        var thischeck = $(this);

        if ( thischeck.is(':checked') ) {

            var currentRow = $(this).closest('tr');
            var count = currentRow.find('td:eq(5)').text();
            thischeck.parents().addClass('danger');
            if (count % 5 == 0) {                   
                var myVar = setTimeout(myTimer, 60000);
            }
            else
            {                   
                var myVar = setTimeout(myTimer, 30000);
            }
        } else {          
           thischeck.parents().removeClass('danger');
           thischeck.parents().removeClass('success');
        }

        function myTimer() {
          thischeck.parents().removeClass('danger');             
          thischeck.parents().addClass('success');
        }

      });"
);


?>
<div class="category-view">
    <h1><?= Html::encode($this->title) ?></h1>
</div>

<?=Html::beginForm(['word/learn'],'post');?>

<?=Html::dropDownList('action', '', ['learn'=>'Выучил',] ,['class'=>'dropdown', ])?>

<?=GridView::widget([
    'options' => ['class' => 'table-responsive'],
    'tableOptions' => ['class' => 'table table-condensed'],
    'dataProvider' => $dataProvider,
    'rowOptions'=>function($model, $key, $index, $column){       
    },
    'columns' => [
       [
         'class' => 'yii\grid\CheckboxColumn',
         'checkboxOptions' => function($model, $key, $index, $widget) {
            return ['value' => $model['id'] ];
          },
        ],
       'id', 'word', 'translation', 'last_update', 'count'],
  ]); ?>

<?=Html::submitButton('Выучил', ['class' => 'btn btn-info',]);?>

<?= Html::endForm();?> 