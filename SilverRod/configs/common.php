<?php

/**
 * many used Functions are in this file
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
if (!function_exists('_fatal_error_handler')) {

    /**
     * adds a custom Fatal Error handler
     * @global object $SR the Silverrod Class
     */
    function _fatal_error_handler() {
        $error = error_get_last();
        if ($error !== NULL) {
            global $SR;
            if (is_object($SR)) {
                $SR->error->fatal($error);
            } else {
                echo '<pre>';
                print_r($error);
                echo '</pre>';
            }
        }
    }

}


if (!function_exists('_custom_error_handler')) {

    /**
     * adds a custom error handler
     * @global object $SR the SilverRod Class
     * @param number $code The ErrorCode (unused)
     * @param string $text The error Text
     * @param string $file The Error file
     * @param number $line The error Line
     */
    function _custom_error_handler($code, $text, $file, $line) {
        $error = array(
            'line' => $line,
            'file' => $file,
            'message' => $text
        );
        global $SR;
        if (is_object($SR)) {
            $SR->error->alert($error);
        }
    }

}


if (!function_exists('load_class')) {

    /**
     * Loads a new Class and saves caches it.
     * If the same Class is used again it will return the already constructed Object
     * @staticvar array $_classes Here are the Objects Cached
     * @param string $class The name of the class that shoud be loaded
     * @param string $directory The Directory of the class (relative to the core or absolute)
     * @return \class
     */
    function &load_class($class, $directory = 'libraries', $param = '', $cache = true) {
        static $_classes = array();
        //If the class already exists
        if (isset($_classes[$class]) && $cache) {
            return $_classes[$class];
        }
        $path = ((!preg_match('/\//', $directory)) ? BASEPATH : '') . $directory . '/' . $class . '.php';
        if (file_exists($path)) {
            if (!class_exists($class)) {
                require($path);
            }
        }
        //If the class was not found
        if (!$class) {
            exit('Class: ' . $class . '.php not found!');
        }
        //Cache the loaded class
        is_loaded($class);
        $_classes[$class] = new $class($param);
        return $_classes[$class];
    }

}


if (!function_exists('is_loaded')) {

    /**
     * Keeps a eye on the loaded classes
     * @staticvar array $_is_loaded Which classes are already loaded
     * @param string $class The class name
     * @return array
     */
    function &is_loaded($class = '') {
        static $_is_loaded = array();
        if ($class != '') {
            $_is_loaded[strtolower($class)] = $class;
        }
        return $_is_loaded;
    }

}


if (!function_exists('load_file')) {

    /**
     * Loads multiplefiles if found
     * @param array $fileArray The files in an array (absolute path neccesarry!)
     */
    function &load_file($fileArray = array()) {
        foreach ($fileArray as $file) {
            if (file_exists($file)) {
                require_once($file);
            }
        }
    }

}


if (!function_exists('get_url')) {

    /**
     * Return the path of a controller
     * @param string $controller the Controllername (maybe with method and param)
     * @return string
     */
    function &get_url($controller) {
        $return = WEBPATH . $controller;
        return $return;
    }

}

if (!function_exists('get_webfolder')) {

    /**
     * returns the path to the public folders
     */
    function get_webfolder($folderName) {
        return WEBFOLDERS . $folderName;
    }

}

if (!function_exists('ifNotSet')) {

    /**
     * Checks if an parameter is defined in an array,
     * if not found use a alternatve.
     * 
     * If it is found start a method (maybe)
     * @param array $array
     * @param string $key The element that shoud be found
     * @param array|string $callback
     * @param variable $replace The Value that shoud be replace the current value (maybe)
     * @return variable
     */
    function ifNotSet($array, $key, $callback = '', $replace = false) {
        if ($callback !== '' && is_callable($callback)) {
            return (isset($array[$key])) ? call_user_func($callback, $array[$key]) : $replace;
        }
        return (isset($array[$key])) ? $array[$key] : $replace;
    }

}