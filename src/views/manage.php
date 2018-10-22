<?php

/* @var $this yii\web\View */
/* @var $model backend\models\UploadForm */

use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

$this->title = '管理' . $label;

$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [],
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => 'hello',
            'closeButton' => false,
            'visible' => false,
        ], 
    ],
];
?>

<div class="row">
    <div class="col-md-12 col-lg-8 col-lg-offset-2">
        <?= $this->render('@drodata/views/_alert')  ?>
        <?php Box::begin(['title' => $subtitle]); ?>
            <?= $this->render('/media/_list', ['dataProvider' => $dataProvider])  ?>

            <div class="row">
                <div class="col-xs-12">
                    <div class="operation-group text-center">
                        <?= implode("\n", $navigationLinks) ?>
                    </div>
                </div>
            </div>

        <?php Box::end(); ?>
    </div>
</div>
