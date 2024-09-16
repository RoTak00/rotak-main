<?php

require_once __DIR__ . '/../modules/mod-include.php';
require_once __DIR__ . '/system/controller.php';

$controller = new BaseController($_GET, $_POST, []);

echo $controller->loadController($_GET['path']);