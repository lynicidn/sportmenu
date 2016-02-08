<?php
namespace app\models;

use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Create password form
 */
class CreatePasswordForm extends Model
{
    public $password;

    /**
     * @var \app\models\User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Registration token cannot be blank.');
        }
        $this->_user = User::findByRegistrationToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong registration token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Create password.
     *
     * @return boolean if password was created.
     */
    public function createPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removeRegistrationToken();
        $user->status = $user::STATUS_ACTIVE;

        return $user->save(false);
    }
}
