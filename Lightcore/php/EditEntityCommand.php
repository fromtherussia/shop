<?php

abstract class EditEntityCommand extends Command {
	const ACTION_GET_PARAM_NAME = 'act';
	private $m_commandNamePrefix;

	public function __construct($accessRights, $commandNamePrefix) {
		parent::__construct($accessRights);
		$this->m_commandNamePrefix = $commandNamePrefix;
	}
	
	protected function GetActionTemplate($actionPostfix) {
		return new Template($this->m_commandNamePrefix . '.' . $actionPostfix);
	}
	
	public function Execute() {
		$action = 'list';
		if (checkString(EditEntityCommand::ACTION_GET_PARAM_NAME, $_GET)) {
			$action = $_GET[EditEntityCommand::ACTION_GET_PARAM_NAME];
		}
		
		$template = NULL;
		switch ($action) {
			case 'list':
				$template = $this->ProcessListAction();
				break;
			case 'search':
				$template = $this->ProcessSearchAction();
				break;
			case 'edit':
				$template = $this->ProcessEditAction();
				break;
			case 'save':
				$template = $this->ProcessSaveAction();
				break;
			case 'delete':
				$template = $this->ProcessDeleteAction();
				break;
		}
		
		if ($template == NULL) {
			return false;
		}
		
		$this->RenderTemplate($template);
		return true;
	}
	
	public static function GetListUrl($comandName) {
		return Command::GetRedirectUrl($comandName, array(EditEntityCommand::ACTION_GET_PARAM_NAME => 'list'));
	}
	
	public static function GetSearchUrl($comandName) {
		return Command::GetRedirectUrl($comandName, array(EditEntityCommand::ACTION_GET_PARAM_NAME => 'search'));
	}
	
	public static function GetEditUrl($comandName, $id) {
		return Command::GetRedirectUrl($comandName, array(EditEntityCommand::ACTION_GET_PARAM_NAME => 'edit', 'id' => $id));
	}
	
	public static function GetAddUrl($comandName) {
		return Command::GetRedirectUrl($comandName, array(EditEntityCommand::ACTION_GET_PARAM_NAME => 'edit', 'id' => -1));
	}
	
	public static function GetSaveUrl($comandName, $id) {
		return Command::GetRedirectUrl($comandName, array(EditEntityCommand::ACTION_GET_PARAM_NAME => 'save', 'id' => $id));
	}
	
	public static function GetDeleteUrl($comandName, $id) {
		return Command::GetRedirectUrl($comandName, array(EditEntityCommand::ACTION_GET_PARAM_NAME => 'delete', 'id' => $id));
	}
	
	abstract public function RenderTemplate($template);
	abstract public function ProcessListAction();
	public function ProcessSearchAction() {
		return NULL;
	}
	abstract public function ProcessEditAction();
	abstract public function ProcessSaveAction();
	public function ProcessDeleteAction() {
		return NULL;
	}
}
