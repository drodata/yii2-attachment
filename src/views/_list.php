<?php

/* @var $this yii\web\View */
/* @var $model backend\models\UploadForm */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

$this->title = '上传' . $model->label;
$this->params = [
    'title' => $this->title,
    'breadcrumbs' => [
    ],
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

<div class="row benchmark-form">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?php Box::begin([
            'title' => $model->subtitle,
        ]); ?>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('上传', ['class' => 'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        <?php Box::end(); ?>

        <?php if ($this->context->action->showUploadedList): ?>
        go
        <?php endif; ?>

        <?= $this->render('@drodata/views/_alert')  ?>
    </div>
</div>
