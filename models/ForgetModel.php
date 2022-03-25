<?php

namespace app\models;

use app\core\Model;
use app\core\Application;

class ForgetModel extends Model
{
    public string $email="";
    public string $name="";
    public string $password="";

    public function rules() :array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_EXIST, 'class' => self::class
            ]],
        ];
    }
    public static function tableName():string
    {
        return "users";
    }

    public function send()
    {   
        $user = RegistModel::findOne(['email' => $this->email]);
        $pass= $this->random(15);
        RegistModel::UpdatePassword(['email' => $this->email],['forget_password' => password_hash($pass, PASSWORD_DEFAULT)]);
        $to = $user->email;
        $subject = 'password';
        $message = $pass;
        if(mail($to, $subject, $message,"")){
            Application::$app->session->setFlash('success', 'Send email');
            return true;
        }
        else{
            $this->addError('email', 'Something went wrong!');
            return false;
        }
    }
}