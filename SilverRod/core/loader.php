<?php

/**
 * loads models, librarys, ect.
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class loader {

    /**
     * 
     * @param class $controller
     */
    public function __construct($controller) {
        if (!is_object($controller)) {
            $back = debug_backtrace();
            $deub = $back[3];
            exit('Es wurde kein richtiges Objekt an den loader auf Zeile [' . $deub['line'] . '] in "' . $deub['file'] . '" &uuml;bergeben');
        }
        $this->controller = $controller;
    }

    /**
     *
     * @var object
     */
    private $controller;

    /**
     * loads the coreclass and chaches it
     * @param string $class
     * @return object
     */
    public function core($class) {
        return load_class($class, 'core');
    }

    /**
     * loads a model and writes it as property
     * @param string $model the model name
     */
    public function model($model) {
        $class = &load_class($model, APPPATH . '/models');
        $this->controller->{$model} = $class;
    }

    /**
     * loads a library and writes it as property
     * @param string $library the library name
     * @param boolean $relative is the library in the Silverrod folder or in the app
     */
    public function library($library, $relative = false, $new = false) {
        $path = ($relative) ? APPPATH . '/' : '';
        $class = &load_class($library, $path . 'libraries', '', $new);
        $this->controller->{$library} = $class;
    }

}
