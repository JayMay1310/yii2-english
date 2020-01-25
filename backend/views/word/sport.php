<?php
use yii\helpers\Html;

?>
<div class="container">
<div class="row">
<ul class="list-group list-group-flush">
<li class='list-group-item'></li>
<li class='list-group-item'></li>
<li class='list-group-item'></li>
<?php
foreach ($query as $model) {
    $word = str_replace("'", "\'", $model['word']);   
    $word_item = "{$word} - {$model['translation']}";
    $id_array[] = $model['id'];
    echo "<li class='list-group-item'><h1>" . $word_item . "</h1></li>";
}
?>
    <?=Html::beginForm(['word/learnsport'],'post');?>
        <input  type="hidden" name="speed" value="<?= implode(",", $id_array); ?>">
        <?=Html::submitButton('Повторил', ['class' => 'btn btn-lg btn-success',]);?>
    <?= Html::endForm();?> 
</ul>
</div>
</div>