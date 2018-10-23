<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item-manage',
    'options' => ['class' => 'row'],
    'itemOptions' => ['class' => 'col-sm-12 col-md-6'],
    'summary' => '',
    'emptyTextOptions' => ['class' => 'col-xs-12'],
]) ?>
