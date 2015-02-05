<?php

/**
 * 
 * @copyright (c) 2015
 * 
 */
class loader_javascript extends SR_Library {

    public function __construct() {
        parent::__construct($this, array());
    }

    private static $javascriptPath = 'js';

    /**
     * 
     * creates a javawscriot tag out of a array or a string
     * @return string 
     */
    public function tag($link) {
        $folder = WEBFOLDERS . 'js/' . preg_replace('/(.*)projects\//', '', APPPATH) . '/';
        if (is_array($link)) {
            $ret = '';
            foreach ($link as $values) {
                $ret.='<script src="' . $folder . $values . '.js"></script>' . "\n";
            }
            return $ret;
        } else {
            return '<script src="' . $folder . $link . '.js"></script>' . "\n";
        }
    }

    /**
     * Loads a javascipt library with a certain verasion
     * @param string $libName The name of the library
     * @param string $version The Version of the library
     * @return string
     */
    public function library($libName, $version = '1.0') {
        $link = $libName . '/' . $version;
        return '<script src="' . $this->applicationPath . '/' . $this->javascriptPath . $link . '.js"></script>' . "\n";
    }

    /**
     * returns a jQuery tag
     * @param string $version
     * @return string
     */
    public function jQuery($version = '1.11.1') {
        return '<script src="//ajax.googleapis.com/ajax/libs/jquery/' . $version . '/jquery.min.js"></script>' . "\n";
    }

}
