<?php

namespace app\core;

abstract class Model
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    //const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';
    const RULE_EXIST = 'exist';

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if(property_exists($this,$key)){
                $this->{$key} =$value;
            }
        }
    }
    abstract public function rules() :array;

    public  array $errors =[];

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorByRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorByRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorByRule($attribute, self::RULE_MIN, ['min' => $rule['min']]);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $db = Application::$app->db;
                    $statement = $db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $statement->bindValue(":$uniqueAttr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorByRule($attribute, self::RULE_UNIQUE);
                    }
                }
                if ($ruleName === self::RULE_EXIST) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $db = Application::$app->db;
                    $statement = $db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $statement->bindValue(":$uniqueAttr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if (!$record) {
                        $this->addErrorByRule($attribute, self::RULE_EXIST);
                    }
                }
            }
        }
        return empty($this->errors);
    }
    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required!',
            self::RULE_EMAIL => 'This field must be valid email address!',
            self::RULE_MIN => 'Min length of this field must be {min}!',
            self::RULE_MAX => 'Max length of this field must be {max}!',
            //self::RULE_MATCH => 'This field must be the same as {match}!',
            self::RULE_UNIQUE => 'Record with this {field} already exists!',
            self::RULE_EXIST => 'User does not exists!',
        ];
    }
    public function errorMessage($rule)
    {
        return $this->errorMessages()[$rule];
    }

    protected function addErrorByRule(string $attribute, string $rule, $params = [])
    {
        $params['field'] ??= $attribute;
        $errorMessage = $this->errorMessage($rule);
        foreach ($params as $key => $value) {
            $errorMessage = str_replace("{{$key}}", $value, $errorMessage);
        }
        $this->errors[$attribute][] = $errorMessage;
    }
    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    public function getFirstError($attribute)
    {
        $errors = $this->errors[$attribute] ?? [];
        return $errors[0] ?? '';
    }
    public function error(){
        $errors=[];
        foreach ($this->rules() as $key => $error) {
            if (!in_array($this->getFirstError($key), $errors)) {
                array_push($errors,$this->getFirstError($key));
            }
        } 
        return $errors;
    }
    public function attributes()
    {
        return [];
    }
    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }
    public function random($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }
    
        return $str;
    }
}