<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Attachment */

?>
<table class="table table-condensed table-bordered">
    <tbody>
        <tr>
            <td class="text-center">
                <?php
                if ($model->isImage) {
                    echo $model->getThumbnail(400);
                } else {
                    echo $model->actionLink('download', [
                        'type' => 'icon',
                    ]);
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="text-center"><?= $model->actionLink('delete', ['icon' => false]) ?></td>
        </tr>
    </tbody>
</table>
