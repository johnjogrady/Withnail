<?php
// show all errors
// ------------
error_reporting(E_ALL);
ini_set('display_errors', 1);

// define DB constants
// ------------
define('DB_HOST', 'localhost');
define('DB_NAME', 'itb');
define('DB_USER', 'fred');
define('DB_PASS', 'smith');

// autoloader
// ------------
require_once __DIR__ . '/../vendor/autoload.php';

// my settings
// ------------
$myTemplatesPath = __DIR__ . '/../templates';

// setup twig
// ------------
$loader = new Twig_Loader_Filesystem($myTemplatesPath);
$twig = new Twig_Environment($loader);
