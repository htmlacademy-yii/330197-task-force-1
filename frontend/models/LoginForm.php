<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Users;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $pass;
    private $_user;

    public function rules()
    {
        return [
            [['email', 'pass'], 'required'],
            ['pass', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->pass)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Users::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}
