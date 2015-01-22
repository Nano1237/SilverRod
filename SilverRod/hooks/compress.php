<?php

/**
 * Compresses the view for less data volume
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
if (!function_exists('compress')) {

    /**
     * Compresses all uneccesarry data
     * @param object $view The called controller
     */
    function compress($view) {
        $c = array(
            '/\n/', // replace end of line by a space
            '/\>[^\S ]+/s', // strip whitespaces after tags, except space
            '/[^\S ]+\</s', // strip whitespaces before tags, except space
            '/(\s)+/s'  // shorten multiple whitespace sequences
        );
        $view->set_output(preg_replace($c, array('', '>', '<', '\\1'), $view->get_output()));
    }

}