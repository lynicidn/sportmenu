<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegisterEmailForm is the model behind the registration form.
 */
class RegisterEmailForm extends Model
{
    public $email;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'targetAttribute' => 'email', 'message' => Yii::t('app', 'Email already exist.')],
        ];
    }

    /**
     * Register new user using the provided email.
     * @return boolean|User whether the user is registered and email is send in successfully
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }
        $this->_user = $user = new User();
        $user->email = $this->email;
        $user->generateAuthKey();
        $user->generateRegistrationToken();

        return $user->save();
    }

    /**
     * Send registration token for activate email
     *
     * @return boolean
     */
    public function sendEmail()
    {
        return Yii::$app->mailer->compose(['html' => 'registerEmailToken-html', 'text' => 'registerEmailToken-text'], ['user' => $this->_user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Registration on ' . Yii::$app->name)
            ->send();
    }
}
