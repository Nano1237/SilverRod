<?php

/**
 * Makes an easy database connection to multiple databases possible
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class loader_database extends SR_Library {

    public function __construct() {
        parent::__construct($this, array('loader_database'));
        $this->error = load_class('loader_error', 'core');
    }

    /**
     * A list with the database connection
     * array(
     *      'name used for acces to the database'=> array(
     *          'variable'=>'name of the mysqli variable',
     *          'file' => 'na,e of the file int he defined database folder'
     *      )
     * )
     * @var array
     */
    private $dbList = array(
        'quickname' => array(
            'variable' => 'var',
            'file' => 'file'
        )
    );

    /**
     * Cached databases
     * @var array
     */
    private $loadedDBs = array();

    /**
     * Current selected database
     * @var string
     */
    private $selected;

    /**
     * Last query is cached
     * @var mysqli_result
     */
    private $lastQuery;

    /**
     * returnes the insert_id
     * @return int
     */
    public function insert_id() {
        return $this->loadedDBs[$this->selected]['db']->insert_id;
    }

    /**
     * 
     */
    public function fetch_assoc_array() {
        if ($this->lastQuery instanceof mysqli_result) {
            $return = array();
            while ($row = $this->lastQuery->fetch_assoc()) {
                array_push($return, $row);
            }
            return $return;
        } else {
            $debug = debug_backtrace();
            $bt = $debug[0];
            $bt['message'] = $this->translate('db', 'fetch_assocNotmysqli_result');
            $this->error->alert($bt);
        }
    }

    /**
     * returns one wanted data of a query
     * @param string $what the column name
     * @return array
     */
    public function fetch_assoc_array_one($what) {
        $return = array();
        foreach ($this->fetch_assoc_array() as $data) {
            if (isset($data[$what])) {
                array_push($return, $data[$what]);
            }
        }
        return $return;
    }

    /**
     * makes a query call
     * @param string $sql The query string
     * @param array $data the data that shoud be injected in the placeholder
     * @param string $dbname the name of a database
     * @return object the query
     */
    public function query($sql, $data = array()) {
        if (isset($this->selected)) {
            $this->lastQuery = $this->loadedDBs[$this->selected]['db']->query($this->arrayToQuery($sql, $data));
            return $this->lastQuery;
        } else {
            $debug = debug_backtrace();
            $bt = $debug[0];
            $bt['message'] = $this->translate('db', 'notConnected');
            $this->error->alert($bt);
        }
    }

    /**
     * switches between the different databases
     * @param string $name the new database name
     * @param boolean $error if errors shoud be shown
     */
    public function switchDB($name) {
        $this->checkDBName($name);
        if (!isset($this->loadedDBs[$name])) {
            $debug = debug_backtrace();
            $bt = $debug[0];
            $bt['message'] = $this->translate('db', 'notLoadet');
            $this->error->alert($bt);
        }
        $this->selected = $name;
    }

    /**
     * Changes the charset of the current database
     * @param string $charset
     */
    public function charset($charset = 'utf8') {
        $this->loadedDBs[$this->selected]['db']->set_charset($charset);
    }

    /**
     * loads a new database
     * @param string $name
     * @param boolean $error
     */
    public function setDB($name, $error = true) {
        if ($this->checkDBName($name)) {
            if (!isset($this->loadedDBs[$name])) {
                $this->loadDB($name);
            } elseif ($error) {
                $dbInfo = $this->loadedDBs[$name]['info'];
                $replace = array(
                    'name' => $name,
                    'file' => path_url($dbInfo['file']),
                    'line' => $dbInfo['line']
                );
                $debug = debug_backtrace();
                $bt = $debug[0];
                $bt['message'] = $this->translate('db', 'alreadyLoadet', $replace);
                $this->error->alert($bt);
            }
        }
    }

    /**
     * checks if a query returns empty
     * @param string $sql
     * @param array $data
     * @return boolean
     */
    public function isEmpty($sql, $in = array()) {
        $data = $this->query($sql, $in);
        return ($data->num_rows === 0);
    }

    /**
     * Returns just one entry
     * @param string $onename
     * @param variable $alternative
     * @return string|int
     */
    public function getOne($onename, $alternative = false) {
        if ($this->lastQuery instanceof mysqli_result) {
            $data = $this->lastQuery->fetch_assoc();
            if (isset($data[$onename])) {
                return $data[$onename];
            }
            return $alternative;
        } else {
            $debug = debug_backtrace();
            $bt = $debug[0];
            $bt['message'] = $this->translate('db', 'fetch_assocNotmysqli_result');
            $this->error->alert($bt);
        }
    }

    /**
     * checks if the database name exists
     * @param string $name
     */
    private function checkDBName($name) {
        $debug = debug_backtrace();
        $bt = $debug[1];
        if (!isset($name)) {
            $bt['message'] = $this->translate('db', 'needName');
            $this->error->alert($bt);
            return false;
        }
        if (!isset($this->dbList[$name])) {
            $bt['message'] = $this->translate('db', 'notFound', array('name' => $name));
            $this->error->alert($bt);
            return false;
        }
        return true;
    }

    /**
     * loads a new database file
     * @param string $name
     */
    private function loadDB($name) {
        $dbFile = __DBFILES__ . $this->dbList[$name]['file'] . '.php';
        if (file_exists($dbFile)) {
            require $dbFile;
            if (isset(${$this->dbList[$name]['variable']})) {
                $debug = debug_backtrace();
                $bt = $debug[1];
                $db = array(
                    'info' => $bt,
                    'db' => ${$this->dbList[$name]['variable']}
                );
                $this->loadedDBs[$name] = $db;
                $this->selected = $name;
            }
        } else {
            echo 'KD!';
        }
    }

    /**
     * Escaped an array into a sql query:
     * ('SELECT * FROM table WHERE ID=? AND col=?',array('ID','col'))
     * @param type $sql 
     * @param type $data 
     * @param type $dbName 
     * @return string
     */
    private function arrayToQuery($sql, $data) {
        if (!isset($data)) {
            return $sql;
        } elseif (!is_array($data)) {
            $data = array($data);
        }
        foreach ($data as $values) {
            if (preg_match('/\%\?\%/', $sql) || $values === 'NULL') {//Wenn es sich um LIKE handelt, die anführungszeichen weglassen
                $sql = preg_replace('/\?/', $this->loadedDBs[$this->selected]['db']->real_escape_string($values), $sql, 1);
            } else {
                $sql = preg_replace('/\?/', "'" . $this->loadedDBs[$this->selected]['db']->real_escape_string($values) . "'", $sql, 1);
            }
        }
        return $sql;
    }

}
