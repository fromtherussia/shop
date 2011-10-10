<?php

function isArray($array) {
	return is_array($array);
}

function isExists($paramName, $array) {
	return array_key_exists($paramName, $array) && isset($array[$paramName]);
}

function safeGetItem($paramName, $array, $defaultValue) {
	return isExists($paramName, $array) ? $array[$paramName] : $defaultValue;
}

function checkNumeric($paramName, $array) {
	if (!isExists($paramName, $array)) {
		return false;
	}
	
	return is_numeric($array[$paramName]);
}

function checkString($paramName, $array) {
	if (!isExists($paramName, $array)) {
		return false;
	}
	
	return is_string($array[$paramName]);
}

function length($param) {
	return strlen($param);
}

function printText($text) {
    echo htmlspecialchars($text);
}

function returnText($text) {
    return htmlspecialchars($text);
}

function escapeSqlSpecialChars($text) {
	return addslashes($text);
}

function firstUpper($text) {
	return ucfirst(strtolower($text));
}

function allLower($text) {
	return strtolower($text);
}

class RequestType {
	const GET = 1;
	const POST = 2;
	const COOKIE = 3;
}

class FiledType {
	const TYPE_NUMERIC = 1;
	const TYPE_STRING = 2;
	const TYPE_ARRAY = 3;
	const TYPE_DATE = 4;
}

function checkFiled($fieldValue, $fieldType) {
	switch ($fieldType) {
		case FiledType::TYPE_NUMERIC:
			return is_numeric($fieldValue);
		case FiledType::TYPE_STRING:
			return is_string($fieldValue);
		case FiledType::TYPE_ARRAY:
			return is_array($fieldValue);
		case FiledType::TYPE_DATE:
			return strtotime($fieldValue) > 1;
	}
	return false;
}

function getFieldValue($fieldName, $fieldType, $requestType, $defaultValue = NULL) {
	$array = NULL;
	switch ($requestType) {
		case RequestType::GET:
			$array = &$_GET;
			break;
		case RequestType::POST:
			$array = &$_POST;
			break;
		case RequestType::COOKIE:
			$array = &$_COOKIE;
			break;
	}
	if ($array == NULL) {
		return $defaultValue;
	}
	
	if (!isExists($fieldName, $array)) {
		return $defaultValue;
	}
	
	$fieldValue = $array[$fieldName];
	if (!checkFiled($fieldValue, $fieldType)) {
		return $defaultValue;
	}
			
	return escapeSqlSpecialChars($fieldValue);
}
