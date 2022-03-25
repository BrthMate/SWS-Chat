<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginModel extends Model
{
    public string $email="";
    public string $name="";
    public string $password="";    

    public function rules() :array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
        ];
    }
    public static function tableName():string
    {
        return "users";
    }
    
    public function login()
    {
        $user = RegistModel::findOne(['email' => $this->email]);
            if (!$user) {
                $this->addError('email', 'User does not exists!');
                return false;
            }
            if (!password_verify($this->password, $user->password) && !password_verify($this->password, $user->forget_password)) {
                $this->addError('password', 'Password is incorrect');
                return false;
            }
            RegistModel::ChangeStatus(['email' => $this->email],["status" => RegistModel::STATUS_ACTIVE]);            
        return Application::$app->login($user);
    }
    public function updateSessionID(){
        $sessionId= $this->random(32);
        RegistModel::UpdatePassword(['email' => $this->email],['sessionID' => $sessionId]);
    }
}