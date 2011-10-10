<?php

class AdminLoginCommand extends Command {
	public function __construct () {
		parent::__construct(VIEWER);
	}
	
	protected static function RenderPage($login = '', $message = '') {
		$template = new Template('AdminLogin');
		if ($login != '') {
			$template->SetParam('login', $login);
			$template->SetError($message);
		}
		wrapAdminTemplate('����', -1, $template)->Render();
	}
	
	public function Execute() {
		// ������� ������������ ������������ �� ������
		$user = new User();
		if ($user->RestoreFromSession()) {
			Command::Redirect('Admin');
		}
		
		if (!isExists('login', $_POST)) {
			AdminLoginCommand::RenderPage();
			return true;
		}
		
		if (!checkString('login', $_POST) || !checkString('password', $_POST)) {
			AdminLoginCommand::RenderPage($login, '������� �������� ���� ����� - ������');
			return true;
		}
		$login = escapeSqlSpecialChars($_POST['login']);
		$password = escapeSqlSpecialChars($_POST['password']);
		
		$user = new User();
		if (!$user->Login($login, $password)) {
			AdminLoginCommand::RenderPage($login, '������������ �� ���������� ��� ������ ��������');
			return true;
		}
		
		Command::Redirect('Admin');
		return true;
	}
};