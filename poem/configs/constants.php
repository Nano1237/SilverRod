<?php

/**
 * 
 * @author Tim Rücker <tim.ruecker@ymail.com>
 * @copyright (c) 2015
 * 
 */
/**
 * The Protokol
 */
$protocol = 'https://';
/**
 * The path to the webfolders
 */
$folderPath = 'poem/';
/**
 * The translationfiles that shoud be loaded
 */
$translationFiles = array(
    'db', 'javascript'
);
/**/
/**/
/**/
/**/
$domain = $protocol . $_SERVER['HTTP_HOST'];
$approot = substr('/kunden' . APPPATH, strlen($_SERVER['DOCUMENT_ROOT']));
//The Folder, containing the mysql objects
define('__DBFILES__', '');
define('WEBPATH', $domain . $approot . '/');
define('WEBFOLDERS', $domain . $folderPath);
