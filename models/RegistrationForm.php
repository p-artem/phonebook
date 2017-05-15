<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegistrationForm extends Model
{
    public $name;
    public $email;
    public $password;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['name','password', 'email'], 'required', 'message' => 'Поле обязательно для заполнения'],
            ['email', 'email', 'message' => 'Неверный формат эл. почты',],
            ['email', 'validateEmail'],
        ];
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($user = $this->getUser()) {
                $this->addError($attribute, 'Такая эл. почта уже существует');
            }
        }
    }

    /*
     * User registration
     */
    public function registration(){
        $user = new User();
        $user->attributes = $this->attributes;
        $user->generateAuthKey();
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);
        if($user->save(false)){
            Yii::$app->user->login($user, 3600*24*30);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Эл. почта',
            'password' => 'Пароль',
        ];
    }
}
