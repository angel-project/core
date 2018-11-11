<?php
namespace angel;

class bootstrap
{
    public function __construct()
    {
        foreach (glob(__dir__.'/src/*') as $file) {
            $method_name = basename($file);
            require_once $file.'/'.$method_name.'.php';
            class_alias('angel\\'.$method_name, $method_name);
        } //Autoload block files

        foreach (glob(str_replace('\vendor\angel-project\core', '', str_replace('/vendor/angel-project/core', '', __dir__)).'/build/*.php') as $file) {
            require_once $file;
        } //Autoload build files


        if ($_SERVER['REQUEST_METHOD']==='POST') {
            run::post(user::uri());
        } else {
            run::get(user::uri());
        }
        //Auto-route

        if (!empty(sql::$connect)) {
            sql::$connect->close();
        }
        //disconnect SQL
    }
}
