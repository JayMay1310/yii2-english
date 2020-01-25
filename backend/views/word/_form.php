<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $categories common\models\Category[] */
/* @var $form yii\widgets\ActiveForm */


$listSelector = ArrayHelper::map($categories, 'id', 'title');
$keyDefaultValue = array_search('Слова собранные мной', $listSelector);

if ($keyDefaultValue === FALSE)
{
    $keyDefaultValue = 0;
}

?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => ['id' => 'dynamic-form']]); ?>

    <?= $form->field($model, 'category_id')->dropDownList($listSelector, ['prompt' => 'Root', 'options' => [ $keyDefaultValue => ['Selected'=>'selected']]]) ?>



    <?php echo $form->field($model, 'word')->widget(Typeahead::classname(), [
            'name' => 'word',
            'options' => ['placeholder' => 'Filter as you type ...'],
            'pluginOptions' => ['highlight'=>true],
                'dataset' => [
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'value',
                    //'prefetch' => $baseUrl . '/samples/countries.json',
                    'remote' => [
                    'url' => Url::to(['word/word-list']) . '?q=%QUERY',
                    'wildcard' => '%QUERY'
                    ]
                ]
            ]

        ]); ?>


    <?= $form->field($model, 'translation')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

