<?php

use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Media */
?>
<table class="table table-condensed">
    <tbody>
        <tr>
            <td class="text-center">
                <?= $model->getThumbnail() ?>
            </td>
        </tr>
</table>
