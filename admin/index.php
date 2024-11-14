<?php


define('BASE_DIR', __DIR__ . '/../');
define('CONTENT_DIR', __DIR__ . '/');

require_once BASE_DIR . 'modules/mod-include.php';
require_once BASE_DIR . 'system/controller.php';
require_once BASE_DIR . 'system/model.php';
require_once BASE_DIR . 'system/db.php';
require_once BASE_DIR . 'system/request.php';
require_once BASE_DIR . 'system/registry.php';
require_once BASE_DIR . 'system/session.php';
require_once BASE_DIR . 'system/user.php';
require_once BASE_DIR . 'system/notification.php';
require_once BASE_DIR . 'system/url.php';
require_once BASE_DIR . 'system/image.php';
require_once BASE_DIR . 'config.php';

ini_set('display_errors', E_ALL);
error_reporting(E_ALL);

$registry = new Registry();

$db = new DB($SERVERNAME, $USERNAME, $PASSWORD, $DATABASE);

$registry->add('db', $db);

$session = new Session($registry);

$registry->add('session', $session);

$request = new Request($registry);

$registry->add('request', $request);

$user = new User($registry);

$registry->add('user', $user);

$notification = new Notification($registry);

$registry->add('notification', $notification);

$url = new Url($registry);

$registry->add('url', $url);

$image = new Image($registry);

$registry->add('image', $image);

$controller = new BaseController($registry);

$path = $_GET['path'] ?? null;

/*if ($path) {
    $path = $url->loadAlias($path);
}*/


echo $controller->loadController($path);