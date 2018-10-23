<?php

/* @var $this yii\web\View */
/* @var $model backend\models\UploadForm */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;
//{$model->viewPath}/{$do}
$this->title = '上传' . $label;
$this->params = [
    'title' => $this->title,
];
?>

<div class="row media-upload-form">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">

        <?php Box::begin([
            'title' => $subtitle,
            'style' => 'success',
        ]); ?>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('上传', ['class' => 'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        <?php Box::end(); ?>

        <!-- Uploaded Media List -->

        <?php if ($this->context->action->showUploadedList && $dataProvider->totalCount): ?>
            <?php Box::begin(['title' => "已上传的$label"]); ?>
                <?= $this->render('_list', ['dataProvider' => $dataProvider])  ?>
            <?php Box::end(); ?>
        <?php endif; ?>

    </div>
</div>
