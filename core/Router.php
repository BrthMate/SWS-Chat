<?php

namespace app\core;

class Router
{
    public Request $Request;
    public Response $Response;
    protected array $rotutes =[];

    public function __construct()
    {
        $this->Request = new Request();
        $this->Response = new Response();
    }
    public function get($path,$callback)
    {
        $this->rotutes['get'][$path] = $callback;
    }
    public function post($path,$callback)
    {
        $this->rotutes['post'][$path] = $callback;
    }
    public function resolve()
    {
        $method = $this->Request->getMethod();
        $url = $this->Request->getUrl();
        $callback = $this->rotutes[$method][$url] ?? false;
        if (!$callback) {
            Application::$app->Response->statusCode(404);
            return $this->renderView("_404");
            exit;
           // throw new NotFoundException();
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            $controller = new $callback[0];
            $controller->action = $callback[1];
            Application::$app->controller = $controller;
            /*$middlewares = $controller->getMiddlewares();
            foreach ($middlewares as $middleware) {
                $middleware->execute();
            }*/
            $callback[0] = $controller;
        }
        return call_user_func($callback, $this->Request);
    }
    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderViewOnly($view,$params);
        return str_replace("{{content}}", $viewContent,$layoutContent);
    }
    protected function layoutContent(){
        if(isset(Application::$app->controller->layout)){
            $layout = Application::$app->controller->layout;
        }else{
            $layout = "layout";
        }
        ob_start();
        include_once Application::$rootPath."/views/layout/$layout.php";
        return ob_get_clean();
    }    
    protected function renderViewOnly($view, $params = [])
    {   
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$rootPath."/views/$view.php";
        return ob_get_clean();
    }
}