<?php

namespace app\core;

abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    public function primaryKey(): string{
        return "id";
    }

    public function register()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public static function prepare($sql): \PDOStatement
    {
        return Application::$app->db->prepare($sql);
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
    public static function UpdatePassword($who,$where){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $findAttribues = array_keys($who);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $sqlWhere = implode("AND", array_map(fn($attr) => "$attr = :$attr", $findAttribues));
        $statement = self::prepare("UPDATE $tableName Set $sql WHERE $sqlWhere");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        foreach ($who as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
    public static function ChangeStatus($who,$where){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $findAttribues = array_keys($who);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $sqlWhere = implode("AND", array_map(fn($attr) => "$attr = :$attr", $findAttribues));
        $statement = self::prepare("UPDATE $tableName Set $sql WHERE $sqlWhere");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        foreach ($who as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
    }
    public static function SelectUsers($who,$where){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $findAttribues = array_keys($who);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $sqlWhere = implode("AND", array_map(fn($attr) => "$attr = :$attr", $findAttribues));
        $statement = self::prepare("UPDATE $tableName Set $sql WHERE $sqlWhere");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        foreach ($who as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
    }
    public function updateSessionID($email,$id){
        $this->UpdatePassword(['email' => $email],['connectionID' => $id]);
    }
}