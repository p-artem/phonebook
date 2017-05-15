<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="site-registration">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => ['id' => 'dynamic-form']
    ]);
    ?>
    <div class="modal-body">
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput(); ?>
    </div>
    <div class="modal-footer">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    <?php ActiveForm::end(); ?>

</div>
