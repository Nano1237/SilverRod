<?php

/**
 * Lädt eine Javascript Klasse, mitder vershciedene Scripts eingebunden werden können
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
class loader_javascript extends SR_Library {

    /**
     * Der Eltern Konstruktor wird nur ausgeführt, um die error klasse zu bekommen
     */
    public function __construct() {
        parent::__construct($this, array());
    }

    /**
     * Der Pfad zu den Javascriptdateien
     * @var string
     */
    private static $javascriptPath = 'js';

    /**
     * Erstellt ein Scripttag mit der Javascript datei als Link oder direkt geladen
     * @param stirng $link Der Pfad zur Javascriptdatei
     * @param boolean $get Ob die Datei geladen werden soll (per file_get_contents())
     * @param boolean $compress Ob die geladene Datei (nur bei $get=true) komprimiert werden soll
     * @return string Der Scripttag mit link oder inhalt
     */
    public function tag($link, $get = false, $compress = true) {
        $folder = WEBFOLDERS . 'js/' . preg_replace('/(.*)projects\//', '', APPPATH) . '/';
        if ($get) {
            return $this->get($link, $compress);
        } else {
            if (is_array($link)) {
                $ret = '';
                foreach ($link as $values) {
                    $ret.='<script src="' . $folder . $values . '.js"></script>' . "\n";
                }
                return $ret;
            } else {
                return '<script src="' . $folder . $link . '.js"></script>' . "\n";
            }
        }
    }

    /**
     * Erstellt einen Scripttag der Relativ zum Projekt steht (in dem Javascript ordner des Projektes)
     * @param string $link Der Dateiname mit oder ohne Pfad innerhalb des Javascriptordners
     * @return string
     */
    public function localtag($link) {
        $url = preg_replace('/([^\/]*\.[^\/]+|\&.*)$/', '', $_SERVER['REQUEST_URI']);
        return '<script src="' . $url . 'javascript/' . $link . '.js"></script>' . "\n";
    }

    /**
     * Lädt eine Javascriptbibliothek aus einem speziellen verzeichniss
     * @param string $libName Der Name zu der Bibliothek
     * @param string $version Die Version der Bibliothek
     * @param boolea $get Ob Sie geladen werden soll
     * @param boolean $compress Ob die geladene Datei auch komprimiert werden soll
     * @return type
     */
    public function library($libName, $version = '1.0', $get = true, $compress = true) {
        $link = $libName . '/' . $version;
        if ($get) {
            return $this->get($link, $compress);
        } else {
            return '<script src="' . WEBFOLDERS . self::$javascriptPath . '/libs/' . $link . '.js"></script>' . "\n";
        }
    }

    /**
     * Lädt die JQuery Bibliothek
     * @param boolean $get Soll sie von Google oder von mcbring kommen (true=google)
     * @param string $version Die JQuery version
     * @return string
     */
    public function jQuery($get = false, $version = '1.11.1') {
        if (is_string($get)) {
            $compress = (is_bool($version) ? $version : true);
            return $this->get('jQuery/' . $get, $compress);
        } else {
            return '<script src="//ajax.googleapis.com/ajax/libs/jquery/' . $version . '/jquery.min.js"></script>' . "\n";
        }
    }

    /**
     * Lädt die JQuery-UI Bibliothek
     * @param boolean $get Soll sie von Google oder von mcbring kommen (true=google)
     * @param string $version Die JQuery-UI version
     * @return string
     */
    public function jQueryUI($get = false, $version = '1.10.3') {
        if (is_string($get)) {
            $compress = (is_bool($version) ? $version : true);
            return $this->get('jQueryUI/' . $get, $compress);
        } else {
            return '<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/' . $version . '/jquery-ui.min.js"></script>' . "\n";
        }
    }

    /**
     * Mithilfe dieser Funktion kann eine Javascriptdatei aus dem Javascriptordner geladen und ausgegeben werden
     * @param string $scriptname Der Name des Scripts
     * @param boolean $compress Ob Das Script komprimiert werden soll
     * @return string
     */
    public function get($scriptname, $compress = true) {
        $file = __DIR__ . '/../' . self::$javascriptPath . '/' . $scriptname . (!preg_match('/\..{2}$/', $scriptname) ? '.js' : '');
        if (file_exists($file)) {
            return $this->formatScript(file_get_contents($file), $compress);
        } else {
            $this->error->alert($this->translate('javascript', 'notFound', array('file' => path_url($file))));
        }
    }

    /**
     * Komprimiert die geladene Javascriptdatei um für den Benutzer Traffic zu sparen
     * @param string $data Die Javascriptdatei
     * @return string
     */
    private function compress($data) {
        return preg_replace('/(\r\n|\n|\s{3,})*/', '', $data);
    }

    /**
     * Formatiert das übergebene Javascript um es mit Scripttags ausgeben zu können
     * @param string $datei Das Script als String
     * @param boolean $compress Ob es komprimiert werden soll oder nicht
     * @return string
     */
    private function formatScript($datei, $compress) {
        if (!preg_match('/^<script>/', $datei)) {
            $datei = "<script>\n" . $datei . "\n</script>";
        }
        return (($compress) ? $this->compress($datei) : $datei) . "\n";
    }

}
