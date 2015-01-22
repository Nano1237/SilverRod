<?php

/**
 * The view class
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class SR_View extends SilverRod {

    public function __construct() {
        parent::__construct();
        $this->javascript = load_class('loader_javascript', 'core');
        $this->style = load_class('loader_style', 'core');
        $this->css = load_class('loader_css', 'core');
        $this->error = load_class('loader_error', 'core');
    }

    /**
     * Hier wird die JavascriptKlasse gespeichert, die sowieso nur für die views benutzt wird
     */
    public $javascript = false;

}
