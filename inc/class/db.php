<?php
require_once str_replace('\\','/',dirname(dirname(__FILE__))).'/' . 'config.php';
class db
{
    public static function query($value){
        $mysqli = new PDO("mysql:host=".localhost.";dbname=".database, username,password);
        $mysqli->exec("SET NAMES utf8");
        $prepare = $mysqli->prepare($value);
        $prepare->execute();
        return $prepare->fetchAll();
    }

    public static function insert($table,$value){
        $sql = "INSERT INTO ".$table." VALUES (".$value.")";
        db::query($sql);
    }
    public static function update($table,$value,$where){
        $sql = "UPDATE ".$table." SET ".$value." WHERE ".$where;
        db::query($sql);
    }
    public static function delete($table,$where=''){
        if($where ==''){
            $sql = "DELETE FROM ".$table;
            db::query($sql);
        }else {
            $sql = "DELETE FROM " . $table . " WHERE" . $where;
            db::query($sql);
        }
    }
    public static function select($table,$value='',$order=''){
        if($value!==''){
            $result=db::query("SELECT * FROM ".$table." WHERE (".$value.") ".$order);
            return $result;
        }
        $result=db::query('SELECT * FROM '.$table.' '.$order);
        return $result;
    }
    public static function count($table,$where){
        if($table!==''){
            $result=db::query('SELECT COUNT(id) AS count FROM '.$table.' WHERE  '.$where);
        }
        return $result;
    }
}