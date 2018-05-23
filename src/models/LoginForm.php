<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace nullref\admin\models;

use nullref\admin\traits\HasModule;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    use HasModule;

    public $username;
    public $password;
    public $rememberMe = true;

    /** @var bool|Admin|null */
    protected $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
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
                $this->addError($attribute, Yii::t('admin', 'Incorrect username or password.'));//Неправильное имя пользователя или пароль.
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return Admin|null
     */
    public function getUser()
    {
        $module = $this->getModule();
        $class = $module->adminModel;
        if ($this->_user === false) {
            $user = call_user_func(array($class, 'findByUsername'), [$this->username]);
            if ($user && ($user->status == Admin::STATUS_ACTIVE)) {
                $this->_user = $user;
            }
        }
        return $this->_user;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->get($this->getModule()->adminComponent)->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 * 3 : 0);
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('admin', 'Username'),
            'password' => Yii::t('admin', 'Password'),
            'rememberMe' => Yii::t('admin', 'Remember Me'),
        ];
    }
} 