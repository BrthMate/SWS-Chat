<?php

namespace app\controllers;

use app\core\Application;
use app\core\BaseController;
use app\core\Request;
use app\models\MsgModel;

class SiteController extends BaseController{

    public function message()
    {
        $params=[];
        return $this->render('message',$params);
    }
    public function search(Request $request){
        $MsgModel= new MsgModel();
        if($request->isGet()){
            if(!$data=json_decode(json_encode(Application::$app->user))){
                Application::$app->Response->redirect("/");
            }
            $MsgModel->loadData($request->getBody());
            $data=json_decode(json_encode(Application::$app->user), true);
            $users=$MsgModel->ShowusersAll(["id"=>$data["id"]]);
        }else{
            $users=null;
        }
        
        return $users;
    }
    public function contact(Request $request){
        $MsgModel= new MsgModel();
        if($request->isGet()){
            if(!$data=json_decode(json_encode(Application::$app->user))){
                Application::$app->Response->redirect("/");
            }
            $MsgModel->loadData($request->getBody());
            $data=json_decode(json_encode(Application::$app->user), true);
            $users=$MsgModel->ShowuserswithMessages(["incoming"=>$data["id"],"outgoing"=>$data["id"]],["id"=>$data["id"]]);
        }else{
            $users=null;
        }
        
        return $users;
    }
    public function unread(Request $request){
        $MsgModel= new MsgModel();
        if($request->isGet()){
            if(!$data=json_decode(json_encode(Application::$app->user))){
                Application::$app->Response->redirect("/");
            }
            $MsgModel->loadData($request->getBody());
            $data=json_decode(json_encode(Application::$app->user), true);
            $users=$MsgModel->ShowuserswithMessagesUnread(
                ["saw" => $MsgModel->read ,"id"=>$data["id"]],
                ["incoming"=>$data["id"],"outgoing"=>$data["id"]]);
        }else{
            $users=null;
        }
        return $users;
    }
    public function chat(Request $request){
        $MsgModel= new MsgModel();
        if($request->isGet()){
            if(!$data=json_decode(json_encode(Application::$app->user))){
                Application::$app->Response->redirect("/");
            }
            $MsgModel->loadData($request->getBody());
            $data=json_decode(json_encode(Application::$app->user), true);
            $users=$MsgModel->UserMessages(
                ["incoming"=>$MsgModel->userId,"outgoing"=>$data["id"]],
                ["incoming"=>$data["id"],"outgoing"=>$MsgModel->userId],
                $data["id"]);
            $MsgModel->UpdateRead(
                ["incoming"=>$MsgModel->userId,"outgoing"=>$data["id"]],
                ["incoming"=>$data["id"],"outgoing"=>$MsgModel->userId],
                $data["id"]);
        }else{
            $users=null;
        }
        return $users;
    }
    public function userdetails(Request $request){
        $MsgModel= new MsgModel();
        if($request->isGet()){
            $MsgModel->loadData($request->getBody());
            $users=$MsgModel->UserData(["id"=>$MsgModel->userId]);
        }else{
            $users=null;
        }
        return $users;

    }
    public function sendmessage(Request $request){
        $MsgModel= new MsgModel();
        if($request->isPost()){
            if(!$data=json_decode(json_encode(Application::$app->user))){
                Application::$app->Response->redirect("/");
            }
            $MsgModel->loadData($request->getBody());
            $data=json_decode(json_encode(Application::$app->user), true);
            if(isset($_FILES["img"]["name"]) && !empty($_FILES["img"]["name"]) ){
                $file="image/".time().$_FILES["img"]['name'];
                move_uploaded_file($_FILES["img"]['tmp_name'],"../public/".$file);
                $result=$MsgModel->sendmessage(["incoming"=>$data["id"],"outgoing"=>$MsgModel->userId,"message"=>$MsgModel->sendText,"saw"=>0,"img"=>"../".$file]);
            }else{
                $result=$MsgModel->sendmessage(["incoming"=>$data["id"],"outgoing"=>$MsgModel->userId,"message"=>$MsgModel->sendText,"saw"=>0]);
            }
        }
        return $result;
    }
}