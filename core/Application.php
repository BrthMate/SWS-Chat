<?php

namespace app\core;

use app\models\MsgModel;
use app\models\RegistModel;

class Application
{
    public RegistModel $userClass;
    public Router $Router;
    public static string $rootPath;
    public Request $Request;
    public Response $Response;
    public static Application $app;
    public BaseController $controller;
    public Database $db;
    public Session $session;
    public ?DbModel $user;
    public MsgModel $MessageModel;
    //public string $keyWord;

    public function __construct($path, array $dbConfig)
    {
        $this->userClass = new RegistModel();
        $this->MessageModel = new MsgModel();
        self::$rootPath = $path;
        self::$app = $this;
        $this->Request = new Request();
        $this->Response = new Response();
        $this->Router = new Router($this->Request, $this->Response);
        $this->db = new Database($dbConfig['db']);
        $this->session = new Session();

       // $this->keyWord = Application::$app->MessageModel->search;

        $userId = Application::$app->session->get('user');
        if ($userId) {
            $key = $this->userClass->primaryKey();
            $this->user = $this->userClass->findOne([$key => $userId]);
        }else{
            $this->user = null;
        }
    }
    public static function isGuest()
    {
        return !self::$app->user;
    }
    public static function UserData(){
        $data=json_decode(json_encode(Application::$app->user));      
        return $data->sessionID;
    }
    public function getController(){
        return $this->controller;
    }
    public function setController($controller){
        $this->controller =$controller;
    }
    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $value = $user->{$primaryKey};
        $this->session->set('user',$value);
        Application::$app->session->set('user', $value);
        return true;
    }
    public function logout()
    {
        $data=json_decode(json_encode($this->user), true);
        $this->userClass->ChangeStatus(["id"=>$data["id"]],["status" => $this->userClass->status]);
        $this->user = null;
        self::$app->session->remove('user');
        
    }
/*
    public static function Showusers(){
        $data=json_decode(json_encode(self::$app->user), true);
        $users=self::$app->MessageModel->ShowusersAll(["id"=>$data["id"]]);
        return $users; 
    }
    public static function ShowusersContact(){
        $data=json_decode(json_encode(self::$app->user), true);
        $users=self::$app->MessageModel->ShowuserswithMessages(["incoming"=>$data["id"],"outgoing"=>$data["id"]],["id"=>$data["id"]]);
        return $users;
    }
    public static function ShowusersMessagesUnread(){
        $data=json_decode(json_encode(self::$app->user), true);
        $users=self::$app->MessageModel->ShowuserswithMessagesUnread(
            ["saw" => self::$app->MessageModel->read ,"id"=>$data["id"]],
            ["incoming"=>$data["id"],"outgoing"=>$data["id"]]);
        return $users;
    }
*/   
    public function run()
    {
       echo $this->Router->resolve();
    }
}