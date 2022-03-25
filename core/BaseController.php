<?php

namespace app\core;

class BaseController
{
    public string $layout = "layout";
    public function render($view,$params=[])
    {
        return Application::$app->Router->renderView($view,$params);
    }
    public function setLayout($layout)
    {
        $this->layout=$layout;
    }
}