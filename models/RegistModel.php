<?php

namespace app\models;

use app\core\DbModel;

class RegistModel extends DbModel
{   
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    //private $height = 100;
    //private $width = 100;

    public string $avatar = "avatar/annie.PNG";
    public string $email="";
    public string $name="";
    public string $password="";
    public int $status = self::STATUS_INACTIVE;

    public static function tableName():string
    {
        return "users";
    }
    public function attributes(): array
    {
        return ['email', 'name', 'password','status','avatar'];
    }
    public function rules() :array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'name' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
        ];
    }
    /*
    function image_resize($file_name, $width, $height, $crop=FALSE) {
        list($wid, $ht) = getimagesize($file_name);
        $r = $wid / $ht;
        if ($crop) {
           if ($wid > $ht) {
              $wid = ceil($wid-($width*abs($r-$width/$height)));
           } else {
              $ht = ceil($ht-($ht*abs($r-$width/$height)));
           }
           $new_width = $width;
           $new_height = $height;
        } else {
           if ($width/$height > $r) {
              $new_width = $height*$r;
              $new_height = $height;
           } else {
              $new_height = $width/$r;
              $new_width = $width;
           }
        }
        $source = imagecreatefromjpeg($file_name);
        $dst = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($dst, $source, 0, 0, 0, 0, $new_width, $new_height, $wid, $ht);
        return $dst;
        //$image = $this->image_resize($this->defaultImage,$this->width,$this->height);
     }*/
     public function register()
     {
         $this->password = password_hash($this->password, PASSWORD_DEFAULT);
         return parent::register();
     }
}