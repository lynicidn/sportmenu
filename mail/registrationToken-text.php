<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

$registrationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/registration', 'token' => $user->registration_token]);
?>
Hello, <?= $user->email ?>,

Follow the link below to continue registration:

<?= $registrationLink ?>
