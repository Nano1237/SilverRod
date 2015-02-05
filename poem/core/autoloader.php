<?php

/**
 * Loads the wanted controller and passes the parameter
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class autoloader {

    /**
     * Loads the classes used in the controller
     */
    public function __construct() {
        global $SR;
        $this->explodeGet();
        $this->requireCore(array(
            'loader_input',
            'loader',
            'poem',
            'SR_Library'
        ));
        $SR = load_class('SR_View', 'core');
        $this->requireCore(array(
            'loader_view',
            'SR_Controller',
            'SR_Model'
        ));
        $this->error = load_class('loader_error', 'core');
        $this->loadController();
    }

    /**
     * 
     * @var array
     */
    private $get = array('');

    /**
     * 
     */
    public function loadController() {
        $home = 'home';
        $path = APPPATH . '/controller';
        $method = isset($this->get[1]) ? $this->get[1] : 'index';
        $param = isset($this->get[2]) ? $this->get[2] : null;
        if ($this->get[0] === '' || $this->get[0] === $home) {
            if (!$this->getController($home, $path, $method, $param)) {
                exit('No Controller found!');
            }
        } else {
            if (!$this->getController($this->get[0], $path, $method, $param) || $this->get[0] === '') {
                $this->error->_404(array('page' => $this->get[0]));
            }
        }
    }

    /**
     * 
     * @param array $files
     */
    private function requireCore($files) {
        foreach ($files as $data) {
            require_once(BASEPATH . '/core/' . $data . '.php');
        }
    }

    /**
     * Formattes the get parameter to getparamaters
     */
    private function explodeGet() {
        $link = '';
        foreach ($_GET as $key => $value) {
            if ($value === '') {
                $link = $key;
            }
        }
        if (!empty($link)) {
            $trimed = trim($link, '/');
            $this->get = explode('/', $trimed);
        }
    }

    /**
     * loads the wanted controller
     * @param string $controller the controller name
     * @param string $path
     * @param string $method 
     * @param string $param
     * @return boolean
     */
    private function getController($controller, $path, $method = 'index', $param = null) {
        if (is_dir($path)) {
            $file = $path . '/' . $controller . '.php';
            if (file_exists($file)) {
                require_once($file);
                $className = strtolower($controller);
                $class = new $className();
                if (method_exists($class, $method)) {
                    $class->{$method}($param);
                } elseif ($method !== '') {
                    exit('error 404');
                }
                return true;
            }
            return false;
        } else {
            exit('No Controller Folder found!');
        }
    }

}
