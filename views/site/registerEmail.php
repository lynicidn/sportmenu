<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegisterEmailForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register email';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register-email">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to register email:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'register-email-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Registration', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
