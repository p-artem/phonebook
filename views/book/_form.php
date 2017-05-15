<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_patronymic')->textInput(['maxlength' => true]) ?>

    <?php $phones = $model->phoneList; $cntPhone = count($phones)?>
    <?php foreach ($phones  as $key => $phone): ?>
        <?php
            if(($key != $cntPhone - 1)){
                $class = 'phoneDel';
                $text = '–';
            } else {
                $class = 'phoneAdd';
                $text = '+';
            }
        ?>
        <?= $form->field($phone, 'phone', ['options'=> ['class' => 'field-book-phones'], 'template' => '
                {label}
                <div class="phoneBlock"> 
                    <div class="input-group">
                        {input}
                        <span class="input-group-addon btn-danger phoneFiled '. $class .'">'. $text .'</span>
                   </div>
                   {error}{hint}
                </div>
       '])
        ->label(($key == 0) ? 'Телефон' : false)
        ->widget(\yii\widgets\MaskedInput::className(), ['options' => ['id' => 'another-id' . ($key + 1)], 'mask' => '+38(099)-999-99-99',  'clientOptions'=>[
            'clearIncomplete'=>true,
        ]])
        ->textInput(['id' => 'another-id' . ($key + 1),  'name' => 'Book[phones][]']);
        ?>
    <?php endforeach;?>

    <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
