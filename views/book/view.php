<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Телефонная книга', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить контакт',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'contact_name',
            'contact_surname',
            'contact_patronymic',
            [
                'label'=>'phone',
                'format'=>'html',
                'value'=>function($model){
                    $ul =  Html::ul($model->phone, ['item' => function($item, $index) {
                        return Html::tag(
                            'li',
                            '+'.$item->phone,
                            ['class' => 'post']
                        );
                    }, 'class' => 'myclass']);

                    return $ul;
                }
            ],
            'address:ntext',
        ],
    ]) ?>

</div>
