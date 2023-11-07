<?php
ob_start();
//autoloader
require_once "Managers/Database.php";
session_start();

spl_autoload_register(function ($className) {
    $baseNamespace = 'classes';

    $classFile = str_replace($baseNamespace, '', $className);
    $classFile = str_replace('\\', '/', $classFile);

    $filePath = '../Private/Managers/' . $classFile . '.php';

    if (file_exists($filePath)) {
        require_once $filePath;
    }
});
