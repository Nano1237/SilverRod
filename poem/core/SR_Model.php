<?php

/**
 * The parent for all models
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class SR_Model extends poem {

    public function __construct($lib) {
        parent::__construct();
        $classes = array(
            'loader' => 'load',
            'loader_Input' => 'input',
            'loader_database' => 'database',
            'loader_error' => 'error'
        );
        $this->loadClasses($lib, $classes);
    }

    /**
     * 
     * @var boolean|object
     */
    protected $database = false;

}
