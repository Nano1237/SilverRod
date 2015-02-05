<?php

/**
 * This class is used for all view actions
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class loader_view {

    /**
     * Returns the view data
     */
    public function __destruct() {
        require_once(BASEPATH . '/core/loader_hook.php');
        new loader_hook($this);
        echo $this->output;
    }

    /**
     * Contains the view data
     * @var string 
     */
    private $output = '';

    /**
     * Returns the view data as string
     * @return string
     */
    public function get_output() {
        return $this->output;
    }

    /**
     * Overrides the view
     * @param string $newView new data
     */
    public function set_output($newView) {
        $this->output = $newView;
    }

    /**
     * 
     * Loads a view and injects variables
     * @global type $SR The poem object for the view actions
     * @param string $vName The View name
     * @param array $insertData The inject data
     * @param boolean $return shoud the rendered view be returned or echo at the end of the file
     * @return string
     */
    public function load($vName, $insertData = array(), $return = false) {
        ob_start();
        global $SR;
        foreach ($insertData as $variable => $data) {
            $$variable = $data;
        }
        include($this->relView($vName));
        $out = ob_get_clean();
        if (!$return) {
            $this->output .= $out;
        }
        return $out;
    }

    /**
     * Checks if the view is a file in the view folder or if it is a file in another directory
     * @param string $namePath The view name|path
     * @return string
     */
    private function relView($namePath) {
        if (preg_match('/\//', $namePath)) {
            return $namePath;
        }
        return APPPATH . '/views/' . $namePath . '.php';
    }

}
