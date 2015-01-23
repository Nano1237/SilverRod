<?php

/**
 * 
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class loader_css extends SR_Library {

    public function __construct() {
        parent::__construct($this, array());
    }

    /**
     * creates a link-tag
     * @param stirng $link The path to the css file
     * @return string 
     */
    public function tag($link) {
        $folder = WEBFOLDERS . 'css/' . preg_replace('/(.*)projects\//', '', APPPATH) . '/';
        if (is_array($link)) {
            $ret = '';
            foreach ($link as $values) {
                $ret.='<link rel="stylesheet" type="text/css" href="' . $folder . $values . '.css">' . "\n";
            }
            return $ret;
        } else {
            return '<link rel="stylesheet" type="text/css" href="' . $folder . $link . '.css">' . "\n";
        }
    }

}
