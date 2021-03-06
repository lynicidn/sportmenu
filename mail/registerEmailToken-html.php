<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$registrationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/create-password', 'token' => $user->registration_token]);
?>
<div class="register-email">
    <p>Hello <?= Html::encode($user->email) ?>,</p>

    <p>Follow the link below to continue registration:</p>

    <p><?= Html::a(Html::encode($registrationLink), $registrationLink) ?></p>
</div>
