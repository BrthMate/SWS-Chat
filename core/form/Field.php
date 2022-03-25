<?php

namespace app\core\form;

use app\core\Model;

class Field
{
    public Model $model;
    public string $attribute;
    public string $class;
    public string $id;
    public string $type;
    public string $placeholder;

    public function __construct($model,$attribute,$class,$id,$placeholder,$type)
    {
        $this->model = $model;
        $this->attribute =$attribute;
        $this->class =$class;
        $this->id =$id;
        $this->type =$type;
        $this->placeholder =$placeholder;
    }
    public function __toString()
    {
        return sprintf('<input type="%s" class="%s" id="%s" placeholder="%s" name="%s" value="%s">',
            $this->type,
            $this->model->hasError($this->attribute) ? $this->class .' is-invalid' : $this->class,
            $this->id,
            $this->placeholder,
            $this->attribute,
            $this->model->{$this->attribute},
            );
    }
}