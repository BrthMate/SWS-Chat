<?php

namespace app\controllers;

use app\core\Application;
use app\core\BaseController;
use app\core\Request;
use app\core\Response;
use app\models\RegistModel;
use app\models\LoginModel;
use app\models\ForgetModel;

class AuthController extends BaseController{

    public function index(Request $request)
    {
        //másik layout használata $this->setLayout('layout_name');
        $LoginModel= new LoginModel();
        if($request->isPost()){

            $LoginModel->loadData($request->getBody());
            
            if($LoginModel->validate() && $LoginModel->login()){
                $LoginModel->updateSessionID();
                Application::$app->Response->redirect("/message");
            }
        }
        return $this->render('index',[
            "model" => $LoginModel
        ]);
    }
    public function regist(Request $request)
    {
        $registModel= new RegistModel();
        if($request->isPost()){

            $registModel->loadData($request->getBody());
            
            if($registModel->validate() && $registModel->register()){
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->Response->redirect("/");
            }
        }
        return $this->render('index',[
            "model" => $registModel
        ]);
    }
    public function forget(Request $request)
    {
        $ForgetModel= new ForgetModel();
        if($request->isPost()){

            $ForgetModel->loadData($request->getBody());
            
            if($ForgetModel->validate() && $ForgetModel->send()){
                Application::$app->Response->redirect("/");
            }
        }
        return $this->render('index',[
            "model" => $ForgetModel
        ]);
    }
    public function logout(Request $request)
    {
        Application::$app->logout();
        Application::$app->Response->redirect("/");
    }
}