<?php
namespace App;

class Router {
    static $get = [];
    static $post = [];

    static function __callStatic($name, $arguments){
        if(strtoupper($name) === $_SERVER['REQUEST_METHOD']){
            self::${strtolower($name)}[] = $arguments;
        }
    }
    static function redirect(){
        $url = explode("?", $_SERVER['REQUEST_URI']);
        foreach(self::${strtolower($_SERVER['REQUEST_METHOD'])} as $page){
            if($page[0] === $url){
                if(isset($page[2])  && $page[2] === "U" && !user()) go("/", "로그인해 주세요.");
                $action = explode("@", $page[1]);
                $conName = "Controller\\{$action[0]}";
                $con = new $conName();
                $con->{$action[1]}();
                exit;
            }
        }
        http_response_code(404);
    }
}