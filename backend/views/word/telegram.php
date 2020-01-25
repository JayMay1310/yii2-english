<?php
use yii\helpers\Html;
$js_array = '';
$id_array = [];

foreach ($query as $model) {
    $word = str_replace("'", "\'", $model['word']);   
    $js_array = $js_array . "'{$word} - {$model['translation']} {$model['last_update']}',";
    $id_array[] = $model['id'];

}
$js = "function nextMsg(i) {
    if (messages.length == i) {      
        i=0;
    }

    $('#count').text(i + '/' + messages.length);

    $('#message').html(messages[i]).fadeIn(500).delay(10000).fadeOut(500, function() {
        $('#count').text(i + '/' + messages.length);
        nextMsg(i + 1);        
    });
}
var messages = [{$js_array}];

    $('#message').hide();

    nextMsg(0);";
    
$this->registerJs($js);

?>

<div class="jumbotron">
        <b id = "count"></b>
        <h2 id="message"></h2>

        <?=Html::beginForm(['word/telegram-learn'],'post');?>
            <input  type="hidden" name="telegram" value="<?= implode(",", $id_array); ?>">
            <?=Html::submitButton('Повторил', ['class' => 'btn btn-lg btn-success',]);?>
        <?= Html::endForm();?> 
</div>