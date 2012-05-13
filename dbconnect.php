<?php

include_once("config.php");
include_once("logging.php");

global $dbh;

function connect() {
	global $dbh, $dbhost, $dbuser, $dbpassword, $db;
	if (!isset($dbh)) {
		$dbh = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Keine SQL Verbindung möglich !");
		mysql_select_db($db) or die("Fehler bei Datenbank Auswahl !");
	}
}

function disconnect() {
	global $dbh;
	
	if (!isset($dbh)) {
		mysql_close($dbh);
	}
}

function switchDb($tablename = "") {
	global $dbmappings, $db;
	
	if (array_key_exists($tablename, $dbmappings)) {
		$local_db = $dbmappings[$tablename];
		logMessage("switchDb: a custom DB mapping is available for table ". $tablename ." => ". $local_db);
		mysql_select_db($local_db) or die("Fehler bei Datenbank Auswahl !");
	}
	else {
		logMessage("switchDb: using default database for table ". $tablename ." => ". $db);
		mysql_select_db($db) or die("Fehler bei Datenbank Auswahl !");
	}
}

?>