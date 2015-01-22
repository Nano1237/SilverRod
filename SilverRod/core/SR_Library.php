<?php

/**
 * Used as parent for all library classes
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class SR_Library extends SilverRod {

    /**
     * 
     * @param object $child The child object
     * @param array $not The classes that shoud <b>NOT</b> be loadet
     */
    public function __construct($child, $not = array()) {
        parent::__construct();
        $classes = array(
            'loader' => 'load',
            'loader_view' => 'view',
            'loader_Input' => 'input',
            'loader_database' => 'database',
            'loader_error' => 'error'
        );
        $this->loadClasses($child, $classes, $not);
    }

}
