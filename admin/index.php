<?php

require_once __DIR__ . '/../modules/mod-include.php';
require_once __DIR__ . '/system/controller.php';

$path = !empty($_GET['path']) ? trim($_GET['path'], '/') : 'home';

$components = explode('/', $path);

// construct the variables for the controller
$class = $components[0];
$function = $components[1] ?? 'index';
$extra_components = array_slice($components, 2);
$params = ['components' => $extra_components, 'get' => $_GET, 'post' => $_POST];

$file = __DIR__ . '/controllers/' . $class . '.php';

if (file_exists($file)) {
    include $file;

    $className = ucfirst($class) . 'Controller'; // test becomes TestController

    if (class_exists($className)) {
        $controller = new $className($_GET, $_POST, $extra_components);
        $output = $controller->$function($params);

        echo $output;
    } else {
        throw new Exception("Class not found: " . $className);
    }
} else {
    throw new Exception("File not found: " . $file);
}