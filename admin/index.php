<?php


require_once __DIR__ . '/../modules/mod-include.php';
require_once __DIR__ . '/system/controller.php';
require_once __DIR__ . '/system/model.php';
require_once __DIR__ . '/system/db.php';
require_once __DIR__ . '/system/request.php';
require_once __DIR__ . '/system/registry.php';
require_once __DIR__ . '/../config.php';

$registry = new Registry();

$db = new DB($SERVERNAME, $USERNAME, $PASSWORD, $DATABASE);

$registry->add('db', $db);

$request = new Request($registry);

$registry->add('request', $request);

$controller = new BaseController($registry->registry);


echo $controller->loadController($_GET['path']);