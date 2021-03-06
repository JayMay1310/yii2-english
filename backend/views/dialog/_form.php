<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $categories common\models\Category[] */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">
    <?php
         
        $items = [];
        for ($i = 1; $i <= 50; $i++) {
            $items[$i] = $i;
        }
        
        $params = [
            'prompt' => 'Выберите шаг...'
        ];
    ?>
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'step')->dropDownList($items,$params) ?>
        <?= $form->field($model, 'dialog')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'translation')->textInput(['maxlength' => 255]) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>