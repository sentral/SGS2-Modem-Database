<?php

$logMessages;
$msgCnt = 0;
$growBy = 10;

function logMessage($msg) {
	global $logMessages;
	global $msgCnt;
	global $growBy;
	
	if (!is_array($logMessages)) {
		$logMessages = array();
	}
	if ($msgCnt + 1 > count($logMessages)) {
		$tmpLogMessages = array_pad($logMessages, count($logMessages) + $growBy, "");
		$logMessages = $tmpLogMessages;
	}
	$logMessages[$msgCnt++] = $msg;
}

function dumpLog() {
	global $logMessages;
	
	if ($logMessages != null && count($logMessages) > 0)
	{
		foreach ($logMessages as $logEntry) {
			echo $logEntry ."<br />";
		}
	}
}

?>
