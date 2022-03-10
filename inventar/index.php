<?php
session_start();
mb_internal_encoding("UTF-8");

function autoloaderFunction($class) {
    if (preg_match('/Controller$/', $class)) {
        require("controllers/" . $class . ".php");
    } else {
        require("models/" . $class . ".php");
	}
}

spl_autoload_register("autoloaderFunction");

Db::connect("127.0.0.1", "root", "", "inventar_project");

$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));

$router->printView();