<?php

class Debug {
	const WARNING_LEVEL_NOTICE = 1;
	const WARNING_LEVEL_WARNING = 2;
	const WARNING_LEVEL_eRROR = 3;
	const LOG_NAME = 'error.log';
}
	
function warningLevelToString($level) {
	switch ($level) {
		case Debug::WARNING_LEVEL_NOTICE:
			return 'NOTICE';
		case Debug::WARNING_LEVEL_WARNING:
			return 'WARNING';
		case Debug::WARNING_LEVEL_eRROR:
			return 'ERROR';
		default:
			return 'NONE';
	}
	return '';
}

function initDebuger() {
	error_reporting(0);
}

function debugLog($message, $warningLevel) {
	$errorLogName = getcwd() . '/' . Debug::LOG_NAME;
	$fileContents = file_get_contents($errorLogName);
	$fileContents .= '[DEBUG][' . warningLevelToString($warningLevel) . '] ' . $message . "\n";
	file_put_contents($errorLogName, $fileContents);
}

function logError($message) {
	debugLog($message, WARNING_LEVEL_eRROR);
}

function logWarning($message) {
	debugLog($message, WARNING_LEVEL_WARNING);
}

function logNotice($message) {
	debugLog($message, WARNING_LEVEL_NOTICE);
}
