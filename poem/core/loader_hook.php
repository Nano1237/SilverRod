<?php

/**
 * Loads the anted hooks (at the moment the hooks are just called at the destruction)
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class loader_hook {

    /**
     * @global array $hooks Die in der Config definierten hooks
     * @param class $controller
     */
    public function __construct($controller) {
        global $hooks;
        $this->hooks = $hooks;
        $this->loadHooks($controller);
    }

    /**
     * The hooks defined in the config.php
     * @var array
     */
    private $hooks;

    /**
     * Loads the wanted hooks
     * @param class $controller
     */
    private function loadHooks($controller) {
        foreach ($this->hooks as $hook) {
            require_once(BASEPATH . '/hooks/' . $hook . '.php');
            $hook($controller);
        }
    }

}
