<?php

/**
 * The core just starts the whole system
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
error_reporting(E_ALL);
date_default_timezone_set('Europe/Berlin');
setlocale(LC_TIME, "de_DE");
$translate = array();
require_once(__DIR__ . '/configs/constants.php');
require_once(__DIR__ . '/configs/config.php');
require_once(__DIR__ . '/configs/common.php');
foreach (array(APPPATH . '/configs/config.php', APPPATH . '/configs/common.php') as $file) {
    if (file_exists($file)) {
        require_once($file);
    }
}
/**/
$language = (isset($language) && !empty($language)) ? 'german' : $language;
$dir = BASEPATH . 'languages/' . $language;
if (is_dir($dir)) {
    foreach ($translationFiles as $values) {
        $file = $dir . '/' . $values . '.php';
        if (file_exists($file)) {
            require_once($file);
        } else {
            exit('Translation ' . $values . ' missing!');
        }
    }
} else {
    exit('Languagefile in ' . get_webfolder($dir) . ' not found!');
}
/**/
register_shutdown_function('_fatal_error_handler');
set_error_handler('_custom_error_handler');

//The Class for the views
$SR;
//now bootstrap everything
load_class('autoloader', 'core');
