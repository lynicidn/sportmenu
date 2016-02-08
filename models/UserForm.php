<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * UserForm is the model behind the user update form.
 */
class UserForm extends Model
{
    public $username;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            ['email', 'email'],
            //считается плохим тоном, брутфорсо дыра для спаммеров, можно коллекционаривать емейлы, но я бы вхуярил
//            ['email', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'email', 'filter' => ['status' => User::STATUS_ACTIVE], 'message' => Yii::t('app', 'Email not active or not exist.')],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('app', 'Incorrect login or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided login and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? Yii::$app->params['user.authKeyExpire'] : 0);
        }
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByLogin($this->email);
        }

        return $this->_user;
    }
}