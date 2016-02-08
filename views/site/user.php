<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\UserForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-user">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to update personal info:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'user-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= \yii\widgets\DetailView::widget([
            'model' => $user = $model->getUser(),
            'attributes' => [
                [
                    'attribute' => 'status',
                    'value' => ArrayHelper::getValue($user->statusLabels(), $user->status)
                ],
                'created_at:dateTime:long',
                'updated_at:dateTime:long',
                'email:email',
            ],
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
