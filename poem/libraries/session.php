<?php

/**
 * A simple session class
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class session {

    /**
     * If no session was started, start a session
     */
    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * Sets a sessiontimeout that shoud be checked before anithing is done
     * @param lambda $callback
     * @param number $time the timeout in minutes
     * @return variable
     */
    public function timeout($callback = false, $time = 45) {
        $timeout = $this->checkTimestamp($time * 60);
        if (\is_callable($callback)) {
            return $callback($timeout);
        } else {
            $this->defaultTimeout($timeout);
        }
    }

    /**
     * 
     * @param String $areaOrName could be a area or projectname if the second value is set, this is handled as area
     * @param String|Boolean $name
     */
    public function get($areaOrName, $name = false) {
        if ($name) {
            if (isset($_SESSION[$areaOrName . '_' . $name])) {
                return $_SESSION[$areaOrName . '_' . $name];
            }
        }
        if (isset($_SESSION[$areaOrName])) {
            return $_SESSION[$areaOrName];
        }
        return false;
    }

    /**
     * 
     * Sets a session value in an area or directly in a value
     * @param String $areaOrName could be a area or projectname if the second value is set, this is handled as area
     * @param String|Boolean $name
     * @param type $data the data that shoud be stored in the session
     */
    public function set($dataOrName, $name = false, $data = null) {
        if (!is_bool($name)) {
            $_SESSION[$dataOrName . '_' . $name] = $data;
        } else {
            $_SESSION[$dataOrName] = $name;
        }
    }

    /**
     * checks if the session is uouttimed
     * @param number $time The session timeout time
     * @return boolean
     */
    private function checkTimestamp($time) {
        if (isset($_SESSION[self::$timestampName])) {
            $timeout = (($_SESSION[self::$timestampName] + $time) - time() >= 0);
            if ($timeout) {
                $_SESSION[self::$timestampName] = time();
            }
            return $timeout;
        }
        return false;
    }

    /**
     * The defualt method done if the session is timeout
     * @param boolean $isSession 
     */
    private function defaultTimeout($isSession) {
        if (!$isSession) {
            header('Location: /');
            exit;
        }
    }

}
