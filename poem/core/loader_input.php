<?php

/**
 * This class is used for the user input per get/post
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class loader_Input {

    /**
     * Returns all wanted get parameters
     * @todo SQL-Injection filter and XSS Filter
     * @param string $index
     * @return variable
     */
    public function get($index = false, $return = false) {
        if ($index) {
            if (isset($_GET[$index])) {
                return $_GET[$index];
            } else {
                if (isset($return) && $return !== false) {
                    return $return;
                }
                return false;
            }
        }
        array_splice($_GET, 0, 1); //removes the routing parameter
        return $_GET;
    }

    /**
     * returns all post parmaters
     * @param string $index
     * @return variable
     */
    public function post($index = false, $other = '') {
        if ($index) {
            if (isset($_POST[$index])) {
                return $_POST[$index];
            } elseif ($other !== '') {
                return $other;
            } else {
                return false;
            }
        }
        return $_POST;
    }

    public function request($index = false) {
        if ($index) {
            if (isset($_REQUEST[$index])) {
                return $_REQUEST[$index];
            } else {
                return false;
            }
        }
        return $_REQUEST;
    }

}
