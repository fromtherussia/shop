<?php

class GlobalMessage {
	const ERROR = 1;
	const SUCCESS = 2;
	const SESSION_KEY_TEXT = "LCGlobalErrorText";
	const SESSION_KEY_TYPE = "LCGlobalErrorType";
	
	public static function Get() {
		if (session_id() == "") {
			return NULL;
		}
		if (!isExists(GlobalMessage::SESSION_KEY_TEXT, $_SESSION) ||
			!isExists(GlobalMessage::SESSION_KEY_TYPE, $_SESSION)) {
			return NULL;
		}
		
		$text = $_SESSION[GlobalMessage::SESSION_KEY_TEXT];
		$type = $_SESSION[GlobalMessage::SESSION_KEY_TYPE];
		
		self::Reset();
		
		return array(
			'text' => $text,
			'type' => $type
		);
	}
	
	public static function Set($text, $type) {
		if (session_id() == "") {
			return false;
		}
		
		$_SESSION[GlobalMessage::SESSION_KEY_TEXT] = $text;
		$_SESSION[GlobalMessage::SESSION_KEY_TYPE] = $type;
		return true;
	}

	public static function Reset() {
		if (session_id() == "") {
			return false;
		}
		
		unset($_SESSION[GlobalMessage::SESSION_KEY_TEXT]);
		unset($_SESSION[GlobalMessage::SESSION_KEY_TYPE]);
		return true;
	}
}