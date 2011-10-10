<?php

$g_connection = NULL;
function get_connection() {
	$DB_HOST = DB_HOST;
	$DB_PORT = DB_PORT;
	$DB_NAME = DB_NAME;
	$DB_USER = DB_USER;
	$DB_PASSWORD = DB_PASSWORD;
	
	global $g_connection;
	if ($g_connection != NULL) {
		return $g_connection;
	}
	if (DB_SILENT_MODE) {
		$g_connection = @pg_connect("host=$DB_HOST port=$DB_PORT dbname=$DB_NAME user=$DB_USER password=$DB_PASSWORD");
	} else {
		$g_connection = pg_connect("host=$DB_HOST port=$DB_PORT dbname=$DB_NAME user=$DB_USER password=$DB_PASSWORD");
	}
	if ($g_connection === FALSE) {
		return NULL;
	}
	return $g_connection;
}

function select($query) {
	$connection = get_connection();
	if ($connection == NULL) {
		return NULL;
	}
	if (DB_SILENT_MODE) {
		$result = @pg_query($connection, $query);
	} else {
		$result = pg_query($connection, $query);
	}
	if ($result === FALSE) {
		return NULL;
	}
	return $result;
}

function update($query) {
	$connection = get_connection();
	if ($connection == NULL) {
		return false;
	}
	if (DB_SILENT_MODE) {
		$result = @pg_query($connection, $query);
	} else {
		$result = pg_query($connection, $query);
	}
	if ($result === FALSE) {
		return false;
	}
	return true;
}

function delete($query) {
	return update($query);
}

function insert($query) {
	return update($query);
}

function fetch_all($queryResult) {
	if ($queryResult == NULL) {
		return NULL;
	}
	$result = array();
	while ($row = pg_fetch_assoc($queryResult)) {
		$result[] = $row;
	}
	return $result;
}

function fetch_row($queryResult) {
	if ($queryResult == NULL) {
		return NULL;
	}
	$row = pg_fetch_assoc($queryResult);
	if (!$row) {
		return NULL;
	}
	return $row;
}

function fetch_one($queryResult, $key) {
	if ($queryResult == NULL) {
		return NULL;
	}
	$row = pg_fetch_assoc($queryResult);
	if (!$row) {
		return NULL;
	}
	if (!array_key_exists($key, $row)) {
		return NULL;
	}
	return $row[$key];
}

function begin_transaction() {
	select("BEGIN;");
}

function end_transaction() {
	select("END;");
}

function roll_back_transaction() {
	select("ROLLBACK;");
}

function setSchema($schemaName) {
	select("SET search_path TO $schemaName, public;");
}