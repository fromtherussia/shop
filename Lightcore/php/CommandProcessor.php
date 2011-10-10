<?php

function location($url) {
	session_write_close();
	header("Location: $url");
	exit();
}

abstract class Command {
	const COMMAND_PARAM_NAME = 'cmd';
	
	private $m_requiredRights;
	private $m_errorDescription = '';

	public function __construct($requiredRights = VIEWER) {
		$this->m_requiredRights = $requiredRights;
	}
	
	public static function GetRedirectUrl($command, $params = NULL) {
		$commandParamName = Command::COMMAND_PARAM_NAME;
		$url = '';
		if ($params != NULL) {
			foreach ($params as $paramName => $paramValue) {
				$url .= "&$paramName=$paramValue";
			}
		}
		$url = "?$commandParamName=$command$url";
		return $url;
	}
	
	public static function Redirect($command, $params = NULL) {
		$url = Command::GetRedirectUrl($command, $params);
		header("Location: $url");
	}
	
	public function Run() {
		$user = new User();
		if ($user->RestoreFromSession()) {	
			$userRights = $user->GetAccessRights();
			if (AccessMode::IsAccessAllowed($this->m_requiredRights, $userRights)) {
				return $this->Execute();
			} else {
				$this->SetError('access denied');
				return false;
			}
		} else {
			$userRights = VIEWER;
			if (AccessMode::IsAccessAllowed($this->m_requiredRights, $userRights)) {
				return $this->Execute();
			} else {
				$this->SetError('access denied');
				return false;
			}
		}
	}
	
	protected function SetError($description) {
		$this->m_errorDescription = $description;
		return true;
	}
	
	public function GetLastError() {
		return $this->m_errorDescription;
	}

	abstract protected function Execute ();
}

class CommandProcessor {
	private $m_commandsDirectory;
	private $m_defaultCommand;
	
	public function __construct($commandsDirectory, $defaultCommand) {
		$this->m_commandsDirectory = $commandsDirectory;
		$this->m_defaultCommand = $defaultCommand;
	}
	
	protected function RunCommand($commandName) {
		$commandsDirectory = $this->m_commandsDirectory;
		$className = $commandName . 'Command';
		$commandFileName = "$commandsDirectory/$className.php";
		
		if (!file_exists($commandFileName)) {
			return false;
		}
		require_once($commandFileName);
		if (!class_exists($className)) {
			return false;				
		}
		try {
			eval('$cmd = new ' . $className . '();');
			return $cmd->Run();
		} catch(Exception $e) {
			return false;
		}
		return false;
	}
	
	public function Run() {
		$commandParamName = Command::COMMAND_PARAM_NAME;
		if (array_key_exists($commandParamName, $_GET) && !empty($_GET[$commandParamName])) {
			if (!$this->RunCommand($_GET[$commandParamName])) {
				return $this->RunCommand($this->m_defaultCommand);
			}
		} else {
			return $this->RunCommand($this->m_defaultCommand);
		}
	}
}