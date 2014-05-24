<?php
// uncomment this for debug
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//ini_set('error_reporting', E_ALL);

mysql_connect(
	"localhost",
	"username",
	"password"
);
mysql_select_db("db_name");
mysql_query("SET NAMES utf8");

// if you cannnot run mathtex on your own, use public available on
define('LATEX_URL', 'http://www.forkosh.com/mathtex.cgi');