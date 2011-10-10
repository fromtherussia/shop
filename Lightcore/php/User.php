<?php

define('VIEWER', 1);
define('EDITOR', 2);
define('USER', 3);
define('ADMIN', 4);

class AccessMode {
	const VIEWER = 1;
	const EDITOR = 2;
	const USER = 3;
	const ADMIN = 4;
	
	public static function IsAccessAllowed ($requiredRights, $userRights) {
		// TODO: change checking algorythm
		return $requiredRights <= $userRights;
	}
}

/**
	Требования:
	CREATE TABLE self::$m_tableName (
		id BIGSERIAL,
		login TEXT,
		password TEXT,
		last_visit TIMESTAMPTZ,
		access_rights INTEGER
	);
*/

define('USER_LOGEDIN_SESSION_KEY', 'loged_in');
define("USER_ACCOUNT_SESSION_KEY", "account_id");

class User
{
	private static $m_tableName;
	private $m_userId = NULL;
	
	public static function SetTableName($tableName) {
		self::$m_tableName = $tableName;
	}
	
	private static function EncodePassword($password) {
		return md5($password);
	}
	
	private static function SetUserData($userId, $userData) {
		unset($userData['id']);
		unset($userData['login']);
		if (count($userData) == 0) {
			return false;
		}
		$updateWhat = array();
		foreach ($userData as $userParam => $paramValue) {
			$updateWhat[] = "$userParam = '$paramValue'";
		}
		$userTableName = self::$m_tableName;
		$updateWhat = implode(', ', $updateWhat);
		return update("UPDATE $userTableName SET $updateWhat WHERE id = $userId;");
	}

	private static function GetUserData($userId) {
		$userTableName = self::$m_tableName;
		return fetch_row(select("SELECT * FROM $userTableName WHERE id = '$userId';"));
	}
	
	public static function IsExists($userName) {
		$userTableName = self::$m_tableName;
		return fetch_one(select("SELECT COUNT(id) AS users_count FROM $userTableName WHERE login = '$userName';"), 'users_count') != 0;
	}
	
	public static function CreateUser($userName, $password, $accessRights) {
		if(User::IsExists($userName)) {
			return false;
		}
		$password = User::EncodePassword($password);
		$userTableName = self::$m_tableName;
		return insert("INSERT INTO $userTableName (login, password, access_rights) VALUES ('$userName', '$password', '$accessRights');");
	}
	
	public static function GetUserInfo($userId) {
		$userData = User::GetUserData($userId);
		unset($userData['password']);
		return $userData;
	}
	
	public static function GetUserPasswordEncoded($userId) {
		$userData = User::GetUserData($userId);
		return $userData['password'];
	}
	
	public static function GetUserIdByName($userName) {
		$userTableName = self::$m_tableName;
		return fetch_one(select("SELECT id FROM $userTableName WHERE login = '$userName';"), 'id');
	}
	
	public static function SetUserInfo($userId, $info) {
		unset($info['password']);
		return User::SetUserData($userId, $info);
	}
	
	public static function SetUserPassword($userId, $password) {
		$password = $this->EncodePassword($password);
		return User::SetUserData($userId, array('password' => $password));
	}
	
	public static function GetUsersData() {
		$userTableName = self::$m_tableName;
		$rows = fetch_all(select("SELECT * FROM $userTableName;"));
		$usersData = array();
		foreach($rows as $row) {
			$usersData[$row['id']] = $row;	
		}
		return $usersData;
	}
	
	public function Touch($userId) {
		$userTableName = self::$m_tableName;
		return update("UPDATE $userTableName SET last_visit = NOW() WHERE id = '$userId';");
	}
	
	private static function IsSessionOpened() {
		if (!array_key_exists(USER_LOGEDIN_SESSION_KEY, $_SESSION)) {
			return false;
		}
		return $_SESSION[USER_LOGEDIN_SESSION_KEY];
	}
	
	private function UnsetSessionUserId() {
		$_SESSION[USER_LOGEDIN_SESSION_KEY] = false;
		$_SESSION[USER_ACCOUNT_SESSION_KEY] = NULL;
	}

	private function SetSessionUserId($userId) {
		$_SESSION[USER_LOGEDIN_SESSION_KEY] = true;
		$_SESSION[USER_ACCOUNT_SESSION_KEY] = $userId;
	}
	
	private static function GetSessionUserId() {
		if (!User::IsSessionOpened()) {
			return -1;
		}
		return $_SESSION[USER_ACCOUNT_SESSION_KEY];
	}
	
	public function GetPasswordEncoded() {
		if (!$this->m_userId) {
			return false;
		}
		$userData = User::GetUserData($this->m_userId);
		return $userData['password'];
	}
	
	public function GetAccessRights() {
		if (!$this->m_userId) {
			return false;
		}
		$userData = User::GetUserData($this->m_userId);
		return $userData['access_rights'];
	}
	
	public function SetPassword($password) {
		if (!$this->m_userId) {
			return false;
		}
		$password = $this->EncodePassword($password);
		return User::SetUserData($this->m_userId, array('password' => $password));
	}
	
	public function SetAccessRights($accessRights) {
		if (!$this->m_userId) {
			return false;
		}
		return User::SetUserData($this->m_userId, array('access_rights' => $accessRights));
	}
	
	public function GetInfo() {
		if (!$this->m_userId) {
			return null;
		}
		$userData = User::GetUserData($this->m_userId);
		unset($userData['password']);
		return $userData;
	}
	
	public function SetInfo($info) {
		if(!$this->m_userId) {
			return null;
		}
		unset($info['password']);
		return User::SetUserData($this->m_userId, $info);
	}
	
	public function Login($userName, $password) {
		if (!User::IsExists($userName)) {
			return false;
		}
		$userId = User::GetUserIdByName($userName);
		if (User::EncodePassword($password) != User::GetUserPasswordEncoded($userId)) {
			return false;
		}
		User::Touch($userId);
		User::SetSessionUserId($userId);
		$this->m_userId = $userId;
		return true;
	}
	
	public function RestoreFromSession() {
		if (!User::IsSessionOpened()) {
			return false;
		}
		$this->m_userId = User::GetSessionUserId();
		return true;
	}
	
	public function IsLoggedIn() {
		return User::IsSessionOpened() && $this->m_userId != NULL;
	}
	
	public function Logout() {
		User::UnsetSessionUserId();
		return true;
	}
}