<?php

/**
 * Runs the autoloader and everything else (bootstrappes)
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class SilverRod {

    public function __construct() {
        global $config;
        global $translate;
        $this->translations = $translate;
        $this->config = $config;
    }

    /**
     * 
     * The configs cached
     * @var array 
     */
    public $config;

    /**
     * the translations cached
     * @var array 
     */
    private $translations;

    /**
     * gets the translations of a certain file
     * @param string $file
     * @param string $variableName
     * @param array $data The translation that shoud be translated
     * @return string
     */
    protected function translate($file, $variableName, $data = array()) {
        if (isset($this->translations[$file]) && isset($this->translations[$file][$variableName])) {
            if (count($data)) {
                foreach ($data as $key => $vals) {
                    $data['%' . $key . '%'] = $vals;
                    unset($data[$key]);
                }
                return strtr($this->translations[$file][$variableName], $data);
            }
            return $this->translations[$file][$variableName];
        }
    }

    /**
     * Loads all classes for the project
     * @param string|object|array $libName The classes that shoud <b>NOT</b> be loadet (because of infinte loops)
     * @param array $classes The classes that shoud be loaded
     */
    protected function loadClasses($libName, $classes, $not = array()) {
        $exclude = $this->classToString($libName, $not);
        foreach ($classes as $class => $varName) {
            if ($this->inData($class, $exclude)) {
                $this->{$varName} = load_class($class, 'core', $libName, false);
            }
        }
    }

    /**
     * Returns the name of a class
     * @param array|object|string $input 
     * @return string|array
     */
    private function classToString($input, $not = array()) {
        $ex = array();
        if (is_object($input)) {
            array_push($ex, get_class($input));
            $ex = array_merge($not, $ex);
        } elseif (is_array($input)) {
            $ex = array_merge($not, $input);
        } elseif (is_string($input)) {
            array_push($not, $input);
            return $not;
        }
        return $ex;
    }

    /**
     * 
     * @param string $needle 
     * @param array|string $data
     * @return boolean
     */
    private function inData($needle, $data) {
        if (is_array($data) && in_array($needle, $data)) {
            return false;
        } elseif (is_string($data) && $needle === $data) {
            return false;
        }
        return true;
    }

}
