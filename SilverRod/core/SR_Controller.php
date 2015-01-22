<?php

/**
 * The aprent for all Controllers
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class SR_Controller extends SilverRod {

    /**
     * 
     * @param object $child the child class
     */
    public function __construct($child) {
        parent::__construct();
        $classes = array(
            'loader' => 'load',
            'loader_view' => 'view',
            'loader_Input' => 'input',
            'loader_error' => 'error'
        );
        $this->loadClasses($child, $classes);
    }

}
