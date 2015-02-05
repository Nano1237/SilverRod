<?php

//path to the poem project
$system_path = __DIR__ . '/../../poem/';

if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}
//sets a trailing slash
if (realpath($system_path) !== FALSE) {
    $system_path = realpath($system_path) . '/';
}
$system_path = rtrim($system_path, '/') . '/';
//checks if the core is found
if (!is_dir($system_path)) {
    exit('Das poem core not found! Is this path correct?' . "\n" . $system_path);
}
//The name of the current file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
//The path to the current project
define('APPPATH', __DIR__);
//The path to the core
define('BASEPATH', str_replace("\\", "/", $system_path));
//loads the core
require_once(BASEPATH . '/core.php');
