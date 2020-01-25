<?php
/* @var $this yii\web\View */
$this->title = 'Yii2 + vue.js';
?>

<div id="app"></div>
<?php $this->registerJsFile(Yii::$app->request->userHost . '/english/web/js/app.js'); ?>