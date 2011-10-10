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
		wrapAdminTemplate('Выход', -1, $template)->Render();
	}

	public function Execute() {
		$user = new User();
		if (!$user->RestoreFromSession()) {
			AdminLogoutCommand::RenderPage('Вход не был осуществлен');
			return true;
		}
		if (!$user->Logout()) {
			AdminLogoutCommand::RenderPage('Не удалось выполнить выход');
			return true;
		}
		AdminLogoutCommand::RenderPage('Выход осуществлен успешно');
		return true;
	}
}