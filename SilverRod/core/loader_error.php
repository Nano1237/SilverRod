<?php

/**
 * Used for different error handling
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class loader_error extends SR_Library {

    public function __construct() {
        parent::__construct($this, array('loader_database'));
        $this->logFile = $this->config['path']['log'] . '/' . date('dmY') . '.csv';
    }

    /**
     * the Errortemplate name
     * @var string
     */
    private $errorTemplate = 'default';

    /**
     * the path to the log files
     * @var string
     */
    private $logFile;

    /**
     * Sets the error level of the file
     * @param number $level 
     */
    public function level($level = 32767) {
        error_reporting($level);
    }

    /**
     * Writes an log entry
     * @param string $message The message to be logged
     * @param string $logType The custom log-type
     * @return boolean
     */
    public function log($message, $logType = 'notice') {
        $backtrace = debug_backtrace();
        return file_put_contents($this->logFile, $this->generateLogString($message, $logType, $backtrace[0]['file'], $backtrace[0]['line']), FILE_APPEND);
    }

    /**
     * echos an error mesage
     * @param string $message a custom message
     */
    public function alert($message = '') {
        $this->errorText($message, 1);
    }

    /**
     * calls the 404 error page
     */
    public function _404($array = array(), $exit = false) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        $this->log('ERROR 404 on ' . $_SERVER['REQUEST_URI'], 'WARNING');
        if (count($array) === 0) {
            $array['page'] = $_SERVER['REQUEST_URI'];
        }
        $this->errorText('', 3, false, '404', $array);
        if ($exit) {
            exit;
        }
    }

    /**
     * calls the error 500 page
     */
    public function _500() {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
        $this->log('ERROR 500 on ' . $_SERVER['REQUEST_URI'], 'ERROR');
        $this->errorText('', 3, false, '500');
    }

    /**
     * shows a fatal error
     * @param array $error
     */
    public function fatal($error) {
        $this->errorText('', 1, false, 'fatal', $error);
    }

    /**
     * Sets defualt values for the error class
     * @param type $errorLevel
     * @param type $custom if set to false the defualt error handler will be used
     */
    public function init($errorLevel, $custom = true) {
        if (isset($errorLevel)) {
            $this->level($errorLevel);
        }
        if (!$custom) {
            restore_error_handler();
        }
    }

    /**
     * Creates a log string for the log files
     * @param string $message 
     * @param string $logType
     * @param string $logFile
     * @param number $logLine 
     * @return string
     */
    private function generateLogString($message, $logType, $logFile, $logLine) {
        return date('H:i:s') . ';'
                . strtoupper($logType) . ';'
                . preg_replace('/;/', '', $message) . ';'
                . $logFile . ';'
                . $logLine . "\n";
    }

    /**
     * gets the defualt error template and returns it with the injected values
     * @param string $message 
     * @param string $backLevel
     * @param number $return shoud the rendered error be returned or directly printed?
     * @param Stirng $template
     * @param array $data
     * @return string
     */
    private function errorText($message = '', $backLevel = 1, $return = false, $template = '', $data = array()) {
        $debugger = debug_backtrace();
        $back = (count($data) === 0) ? $debugger[$backLevel] : $data;

        if (is_array($message)) {
            $back = $message;
        }
        $template = ($template !== '') ? $template : $this->errorTemplate;
        if (!isset($back['message'])) {
            $back['message'] = $message;
        }
        if (isset($back['file'])) {
            $back['file'] = path_url($back['file']);
        }
        return $this->view->load(BASEPATH . 'error/' . $template . '.php', $back, $return);
    }

}
