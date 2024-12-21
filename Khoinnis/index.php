<?php
    session_start();
    define('WEBROOT', str_replace("index.php", "", $_SERVER["SCRIPT_NAME"]));
    require_once 'core/routers.php';
    

    $router = new Router();
   // echo "Chuỗi file";
  //  echo $_SERVER['REQUEST_URI'];
    $router->dispatch($_SERVER['REQUEST_URI']);
?>