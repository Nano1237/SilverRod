<?php

/**
 * This is an example controller.
 * You can acces it if you browse to /SilverRod/projects/pname/demo.
 * It will then start the <b>index() method</b>.
 * 
 * If you browse to /SilverRod/projects/pname/demo/variable 
 * it will start the </b>variable() method</b>
 * 
 * If you browse to /SilverRod/projects/pname/demo/variable/Cookie 
 * it will start the </b>variable() method</b> with the $param set as 'Cookie'
 */
class demo extends SR_Controller {

    public function __construct() {
        parent::__construct($this);
    }

    /**
     * Shows the /SilverRod/projects/pname/views/view.php with the containing
     * $someVariable set as $someVariable = $variable
     * @param String $variable
     */
    private function showView($variable) {
        $this->view->load('view', array(
            'someVariable' => $variable
        ));
    }

    /**
     * 
     * A controller method that can be called 
     * @param type $param
     */
    public function variable($param = 'default Value') {
        $this->showView($param);
    }

    /**
     * The defualt controller method
     */
    public function index() {
        $this->showView('index Page');
    }

}
