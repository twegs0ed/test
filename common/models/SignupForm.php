<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $region_id;
    public $FIO;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
           // ['region_id', 'required'],
            ['region_id', 'integer'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        //$user->FIO = $this->FIO;
        //$user->region_id = $this->region_id;
        //$user->outpost_id = $this->outpost_id;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $role='guest';
        
        
        if ($user->save()) {
            $auth = Yii::$app->authManager;
            $roleto = $auth->getRole($role);
            $auth->assign($roleto, $user->getId());
            return $user;
        }
    }
     public function signupvk()
    {
        
        /*if (!$this->validate()) {
            return null;
        }*/
        
        $user = new User();
        
        $user->username = $this->username;
        $user->FIO = $this->FIO;
        //$user->region_id = $this->region_id;
        //$user->outpost_id = $this->outpost_id;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $role='guest';
        //die(var_dump($user));
        
        if ($user->save()) {
            $auth = Yii::$app->authManager;
            $roleto = $auth->getRole($role);
            $auth->assign($roleto, $user->getId());
            return $user;
        }else die(var_dump($user->getErrors()));
    }
}