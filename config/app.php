<?php
session_start();
date_default_timezone_set('Europe/Kiev');

require_once __DIR__ . '/../vendor/autoload.php';

define('RB', __DIR__ . '/../libs/rb.php');
define('DB', __DIR__ . '/db.php');
define('BASE_URL', 'http://j977578b.beget.tech/');
define('FULLPATH', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
define('REQUEST', str_replace(BASE_URL, '', FULLPATH));

$pathParts = explode('/', REQUEST);

if (!empty($controller = $pathParts[0]))
{
    define('CONTROLLER', $controller);
} else
{
    define('CONTROLLER', null);
}

if (!empty($action = explode('?', $pathParts[1])))
{
    define('ACTION', array_shift($action));
} else
{
    define('ACTION', null);
}

define('WEB', BASE_URL . 'webroot/');
define('ELEMENTS', __DIR__ . '/../src/Views/Elements/');