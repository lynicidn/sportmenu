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

    public function init()
    {
        parent::init();
        $this->username = $this->getUser()->username;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['username', 'string', 'min' => 3, 'max' => 32],
            ['username', 'match', 'pattern' => '/^[a-z0-9-_\.]+$/i'],
        ];
    }

    /**
     * Update user using the provided username.
     * @return boolean whether the user is updated in successfully
     */
    public function update()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->username = $this->username;
            return $user->save();
        }
        return false;
    }

    /**
     * Get current logged user
     *
     * @return User
     */
    public function getUser()
    {
        return Yii::$app->user->getIdentity();
    }
}
