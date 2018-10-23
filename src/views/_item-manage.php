<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Attachment */

?>
<table class="table table-condensed table-bordered">
    <tbody>
        <tr>
            <td class="text-center">
                <?= $model->getThumbnail(400) ?>
            </td>
        </tr>
        <tr>
            <td class="text-center"><?= $model->actionLink('delete', ['icon' => false]) ?></td>
        </tr>
    </tbody>
</table>
