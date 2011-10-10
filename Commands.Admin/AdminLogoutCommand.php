<?php

class AdminLogoutCommand extends Command {
	public function __construct() {
		parent::__construct(EDITOR, false);
	}
	
	protected static function RenderPage($message = '') {
		$template = new Template('AdminLogout');
		if ($message != '') {
			$template->SetMessage($message);
		}
		wrapAdminTemplate('�����', -1, $template)->Render();
	}

	public function Execute() {
		$user = new User();
		if (!$user->RestoreFromSession()) {
			AdminLogoutCommand::RenderPage('���� �� ��� �����������');
			return true;
		}
		if (!$user->Logout()) {
			AdminLogoutCommand::RenderPage('�� ������� ��������� �����');
			return true;
		}
		AdminLogoutCommand::RenderPage('����� ����������� �������');
		return true;
	}
}