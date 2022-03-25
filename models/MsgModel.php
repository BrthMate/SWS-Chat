<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;

class MsgModel extends DbModel
{
    const READ_MESSAGE = 1;
    public int $read = self::READ_MESSAGE;
    public string $search="";
    public string $userId="";
    public string $sendText="";

    public string $name="";
    public string $email="";
    public string $password="";
    public string $imgName="";

    public static function tableName():string
    {
        return "users";
    }
    public static function tableName2():string
    {
        return "messages";
    }
    public function attributes(): array
    {
        return ['email', 'name', 'password'];
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
    public function ShowusersALL($where,){
        $tableName = static::tableName();
        $tableName2 = static::tableName2();
        $attributes = array_keys($where);
        $sqlWhere = implode(" AND ", array_map(fn($attr) => "$attr != :$attr", $attributes));
        $statement = self::prepare("SELECT id,name,avatar,status FROM $tableName WHERE $sqlWhere AND name LIKE '%{$this->search}%'");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        
        $statement->execute();

        $output ="";
        $img="";
        
        foreach ($statement->fetchAll() as $key => $value) {
            $stmt = self::prepare("SELECT message,msg_created_at,img FROM $tableName2 WHERE (incoming = {$value["id"]} AND outgoing = {$where['id']} ) OR (incoming ={$where['id']}  AND outgoing ={$value["id"]}) ORDER BY msg_id DESC LIMIT 1");
            $stmt->execute();
            $row = $stmt->fetchAll();
            if( empty($row)){
                $message =  '<p class="card-text">Nincs Üzenet</p>';
            }else{
                foreach ($row as $key => $row) {
                    if($row["img"]!=""){
                        $img ="(Képet küldött)";
                    }elseif ($row["img"]=="") {
                        $img="";
                    }
                    $message ='<p class="card-text">'.$row["message"]." " .$img.'</p>
                        <span  style= "font-size: 13px;">'. substr($row["msg_created_at"],strpos($row["msg_created_at"], " "),-3).'</span>';
                
                }
            }
            if($value['status'] == $this->read){
                $status=" user-active";
            }else{
                $status = "";
            } 
            $output .= 
            '<div class="mt-3 searched-user active" >
            <a class="user-id" href="/message?usercode='.$value['id'].'" onclick="userId('.$value['id'].')">
                    <div class="card w-100 box">
                        <div class="card-body d-flex">
                            <img  class ="profile-image big'.$status.'" src='.$value["avatar"].' alt="">
                            <div class="profile-details">
                            <h5 class="card-title mb-1"><strong>'.$value["name"].'</strong></h5>  
                            '.$message.'
                            </div>
                        </div>
                    </div>
                </a>
            </div>';
            }
        return $output;
    }
    public function ShowuserswithMessages($OR,$AND)
    {
        $tableName = static::tableName();
        $tableName2 = static::tableName2();
        $attributesOR = array_keys($OR);
        $attributesAND = array_keys($AND);
        $sqlOR = implode(" OR ", array_map(fn($attr) => "$attr = :$attr", $attributesOR));
        $sqlAND = implode(" AND ", array_map(fn($attr) => "$attr != :$attr", $attributesAND));
        $statement = self::prepare("SELECT name,avatar,id,status FROM $tableName INNER JOIN $tableName2  ON $tableName.id = $tableName2.incoming OR $tableName.id = $tableName2.outgoing  WHERE ($sqlOR) AND $sqlAND GROUP BY id");
        foreach ($OR as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        foreach ($AND as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();

        $output ="";
        $img="";

        foreach ($statement->fetchAll() as $key => $value) {
            $stmt = self::prepare("SELECT message,msg_created_at,saw,img FROM $tableName2 WHERE (incoming = {$value["id"]} AND outgoing = {$AND['id']} ) OR (incoming ={$AND['id']}  AND outgoing ={$value["id"]}) ORDER BY msg_id DESC LIMIT 1");
            $stmt->execute();
            $row = $stmt->fetchAll();
            if( empty($row)){
                $message =  '<p class="card-text">Nincs Üzenet</p>';
            }else{
                foreach ($row as $key => $row) {
                    if($row["img"]!=""){
                        $img ="(Képet küldött)";
                    }elseif ($row["img"]=="") {
                        $img="";
                    }
                    if ($row['saw']==0) {
                        $message ='<p class="card-text"><strong>'.$row["message"]." ".$img.'</strong></p>
                        <span style= "font-size: 13px;">'. substr($row["msg_created_at"], strpos($row["msg_created_at"], " "), -3).'</span>';
                    }else{
                        $message ='<p class="card-text">'.$row["message"]." ".$img.'</p>
                        <span  style= "font-size: 13px;">'. substr($row["msg_created_at"],strpos($row["msg_created_at"], " "),-3).'</span>';
                    }
                }
            }
            if($value['status'] == $this->read){
                $status=" user-active";
            }else{
                $status = "";
            }
            $output .= 
            '<div class="mt-3 contact-user active" >
                <a class="user-id" href="/message?usercode='.$value['id'].'" onclick="userId('.$value['id'].')">                    
                    <div class="card w-100 box">
                        <div class="card-body d-flex">
                            <img  class ="profile-image big '.$status.'" src='.$value["avatar"].' alt="">
                            <div class="profile-details">
                            <h5 class="card-title mb-1"><strong>'.$value["name"].'</strong></h5>  
                            '.$message.'
                            </div>
                        </div>
                    </div>
                </a>
            </div>';
            }
        return $output;
    }
    public function ShowuserswithMessagesUnread($unequal, $equal)
    {
        $tableName = static::tableName();
        $tableName2 = static::tableName2();
        $attributesUnequal = array_keys($unequal);
        $attributesEqual = array_keys($equal);
        $WHEREunequal = implode(" AND ", array_map(fn($attr) => "$attr != :$attr", $attributesUnequal));
        $WHEREequal = implode(" OR ", array_map(fn($attr) => "$attr = :$attr", $attributesEqual));
        $statement = self::prepare("SELECT id,name,avatar,status FROM $tableName INNER JOIN $tableName2  ON $tableName.id = $tableName2.incoming OR $tableName.id = $tableName2.outgoing  WHERE $WHEREunequal AND ($WHEREequal)  AND  incoming != {$unequal['id']} GROUP BY id");
        foreach ($unequal as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        foreach ($equal as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();

        $output ="";
        $img="";

        foreach ($statement->fetchAll() as $key => $value) {
            $stmt = self::prepare("SELECT message,msg_created_at,img FROM $tableName2 WHERE (incoming = {$value["id"]} AND outgoing = {$unequal['id']}) OR (incoming ={$unequal['id']}  AND outgoing ={$value["id"]} AND saw != $this->read AND incoming != {$unequal['id']}) ORDER BY msg_id DESC LIMIT 1");
            $stmt->execute();
            $row = $stmt->fetchAll();
            if( empty($row)){
                $message =  '<p class="card-text">Nincs Üzenet</p>';
            }else{
                foreach ($row as $key => $row) {
                    if($row["img"]!=""){
                        $img ="(Képet küldött)";
                    }elseif ($row["img"]=="") {
                        $img="";
                    }
                    $message ='<p class="card-text">'.$row["message"]." ".$img.'</p>
                        <span style= "font-size: 13px;">'. substr($row["msg_created_at"],strpos($row["msg_created_at"], " "),-3).'</span>';
                
                }
            }
            if($value['status'] == $this->read){
                $status=" user-active";
            }else{
                $status = "";
            }
            $output .= 
            '<div class="mt-3" >
                <a class="user-id" href="/message?usercode='.$value['id'].'" onclick="userId('.$value['id'].')">                    
                    <div class="card w-100 box">
                        <div class="card-body d-flex">
                        <img  class ="profile-image big  '.$status.'" src="'. $value["avatar"] .'" alt="">
                        <div class="profile-details">
                            <h5 class="card-title mb-1"><strong>'. $value["name"].'</strong></h5>
                            '. $message.'
                        </div>
                        </div>
                    </div>
                </a>
            </div>';
            }
        return $output;
    }
    public function UserMessages($first, $second,$userid){
        $tableName = static::tableName();
        $tableName2 = static::tableName2();
        $attributesFirst = array_keys($first);
        $attributesSecond = array_keys($second);
        $WHEREfirst = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributesFirst));
        $WHEREsecond = implode(" AND ", array_map(fn($attr) => "$attr = :$attr"."second", $attributesSecond));
        $statement = self::prepare("SELECT message,incoming,outgoing,saw,msg_created_at,img FROM $tableName INNER JOIN $tableName2  ON $tableName.id = $tableName2.incoming OR $tableName.id = $tableName2.outgoing  WHERE ($WHEREfirst) OR ($WHEREsecond) GROUP BY msg_created_at,message ORDER BY  msg_created_at");
        foreach ($first as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        foreach ($second as $key => $item) {
            $statement->bindValue(":$key"."second", $item);
        }
        $statement->execute();
        $message="";
        foreach ($statement->fetchAll() as $key => $value) {
            if($value["incoming"] != $userid && empty($value["img"])){
                $message.= '
                <div class="d-flex flex-row py-1">
                    <span class="d-inline-block px-3 py-2  text-light get">'.$value["message"].'</span>
                </div>';
            }elseif($value["incoming"] == $userid && $value["saw"] == 0 && empty($value["img"])){
                $message.='
                <div class="d-flex flex-row-reverse p-2 py-1">
                    <span class="d-inline-block px-3 py-2  text-light get ">'.$value["message"].'</span>
                </div>' ;
            }elseif($value["incoming"] == $userid && $value["saw"] == 1 && empty($value["img"])){
                $message.='
                <div class="d-flex flex-row-reverse p-2 py-1">
                    <span class="d-inline-block px-3 py-2  send text-light">'.$value["message"].'</span>
                </div>' ;
            }

            if($value["incoming"] != $userid && !empty($value["img"]) && empty($value["message"])){
                $message.= '
                <div class="d-flex flex-row py-1">
                    <img class="d-inline-block py-2 image-massages" src="'.$value["img"].'">
                </div>';        
            }elseif($value["incoming"] == $userid && !empty($value["img"]) && empty($value["message"])){
                $message.= '
                <div class="d-flex flex-row-reverse py-1 ">
                    <img class="d-inline-block py-2 image-massages" src="'.$value["img"].'">
                </div>';     
            }elseif($value["incoming"] != $userid && !empty($value["img"]) && !empty($value["message"])){
                $message.= '
                <div class="d-flex flex-column py-1">
                    <img class="d-inline-block image-massages with-text" src="'.$value["img"].'">
                    <span class="d-inline-block px-3 image-massages py-2 text-light with-img get">'.$value["message"].'</span>
                </div>';        
            }elseif($value["incoming"] == $userid && !empty($value["img"]) && !empty($value["message"]) && $value["saw"] == 1){
                $message.= '
                <div class="d-flex flex-column align-items-end py-1  ">
                    <img class="d-inline-block  with-text image-massages" src="'.$value["img"].'">
                    <span class="d-inline-block px-3 py-2  image-massages send with-img text-light">'.$value["message"].'</span>
                </div>';           
            }elseif($value["incoming"] == $userid && !empty($value["img"]) && !empty($value["message"] && $value["saw"] == 0)){
                $message.= '
                <div class="d-flex flex-column align-items-end py-1  ">
                    <img class="d-inline-block  with-text image-massages" src="'.$value["img"].'">
                    <span class="d-inline-block px-3 py-2  image-massages get with-img text-light">'.$value["message"].'</span>
                </div>';     
            }
        }
        $output = 
            '<div class="message-content ">
                '.$message.'
            </div>';

        return $output;
    }
    public function UserData($where){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $WHERE = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT id,name,avatar,status,sessionID FROM $tableName  WHERE $WHERE ");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        foreach ($statement->fetchAll() as $key => $value) {
            if($value['status'] == $this->read){
                $status=" user-active";
            }else{
                $status = "";
            } 
            $output= '
                <div class="personal-detail d-flex align-items-center">
                    <img  class ="profile-image box-content litle  '.$status.'" src="'.$value['avatar'].'" alt="">
                    <div class="profile-details m-auto">
                        <h5 class="card-title personal-detail-box"><strong>'.$value['name'].'</strong></h5>
                    </div>
                </div>
                <div class="option  d-flex my-auto">
                    
                    <button class=" btn " id="videoCall" data-user='.$value['sessionID'].'>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--Black)"><path d="M18 7c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-3.333L22 17V7l-4 3.333V7z"></path></svg></span>
                    </button>
                </div>
                ';
                /*
                    <button class="btn " id="call" data-user='.$value['sessionID'].'>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--Black)"><path d="M20 10.999h2C22 5.869 18.127 2 12.99 2v2C17.052 4 20 6.943 20 10.999z"></path><path d="M13 8c2.103 0 3 .897 3 3h2c0-3.225-1.775-5-5-5v2zm3.422 5.443a1.001 1.001 0 0 0-1.391.043l-2.393 2.461c-.576-.11-1.734-.471-2.926-1.66-1.192-1.193-1.553-2.354-1.66-2.926l2.459-2.394a1 1 0 0 0 .043-1.391L6.859 3.513a1 1 0 0 0-1.391-.087l-2.17 1.861a1 1 0 0 0-.29.649c-.015.25-.301 6.172 4.291 10.766C11.305 20.707 16.323 21 17.705 21c.202 0 .326-.006.359-.008a.992.992 0 0 0 .648-.291l1.86-2.171a1 1 0 0 0-.086-1.391l-4.064-3.696z"></path></svg></span>
                    </button>
                */
            
        }
        return $output;
    }
    public function UpdateRead($first, $second,$id){
        $tableName2 = static::tableName2();
        $attributesFirst = array_keys($first);
        $attributesSecond = array_keys($second);
        $WHEREfirst = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributesFirst));
        $WHEREsecond = implode(" AND ", array_map(fn($attr) => "$attr = :$attr"."second", $attributesSecond));
        $statement = self::prepare("UPDATE $tableName2 SET saw = $this->read  WHERE ($WHEREfirst) OR ($WHEREsecond) AND incoming != $id");
        foreach ($first as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        foreach ($second as $key => $item) {
            $statement->bindValue(":$key"."second", $item);
        }
        $statement->execute();
    }
    public function sendmessage($insert){
        $tableName2 = static::tableName2();
        $attributes = array_keys($insert);
        $params = array_map(fn($attr) => "'$attr'", $insert);
        $statement = self::prepare("INSERT INTO $tableName2 (" . implode(",", $attributes) . ",msg_created_at) 
                VALUES (" . implode(",", $params) . ",NOW())");
        $statement->execute();
        return true;
    }
    public function updateUser($id){
        $user = RegistModel::findOne(['id' => $id]);
        RegistModel::UpdatePassword(['id' =>$user->id],["name"=>$this->name]);
        RegistModel::UpdatePassword(['id' =>$user->id],["email"=>$this->email]); 
        RegistModel::UpdatePassword(['id' =>$user->id],['password' => password_hash($this->password, PASSWORD_DEFAULT)]); 
        if($this->imgName!=""){
            RegistModel::UpdatePassword(['id' =>$user->id],['avatar' =>$this->imgName]);
            unlink(substr($user->avatar,3)); 
        }
    } 
}