<?php

/**
 * A library for css tags in the view
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class loader_style extends SR_Library {

    public function __construct() {
        parent::__construct($this, array());
    }

    /**
     * creates a styletag relatively to the project (in the css folder of the project)
     * @param string $link
     * @return string
     */
    public function localtag($link) {
        $url = preg_replace('/([^\/]*\.[^\/]+|\&.*)$/', '', $_SERVER['REQUEST_URI']);
        return '<link rel="stylesheet" href="' . $url . 'css/' . $link . '.css" />' . "\n";
    }

    /**
     * creates a styletag with an external anchor
     * @param stirng $link
     * @return string 
     */
    public function tag($link) {
        $folder = WEBFOLDERS . 'css/' . preg_replace('/(.*)projects\//', '', APPPATH) . '/';
        if (is_array($link)) {
            $ret = '';
            foreach ($link as $values) {
                $ret.='<link rel="stylesheet" href="' . $folder . $values . '.css" />' . "\n";
            }
            return $ret;
        } else {
            return '<link rel="stylesheet" href="' . $folder . $link . '.css" />' . "\n";
        }
    }

}
