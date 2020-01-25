<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Category;
?>

<?php
    $items = Category::find()->select(['title', 'id'])->indexBy('id')->column();
    $params = [
        'prompt' => 'Выберите категорию...'
    ];
?>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'category')->dropDownList($items, $params) ?>
    <?= $form->field($model, 'word')->textarea(['rows' => 50])->label('Separate "—"') ?>
    <button>Отправить</button>
<?php ActiveForm::end() ?>