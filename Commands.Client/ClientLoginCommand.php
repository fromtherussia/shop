<?php

class ClientLoginCommand extends Command {
	public function RenderDefaultPage($name = '', $login = '') {
		$template = new Template('ClientLogin');
		$template->SetParam('name', $name);
		$template->SetParam('login', $login);
		wrapSubpageTemplate('Вход / Регистрация', 1, $template)->Render();
		return true;
	}
	
	public function Execute () {
		$user = new User();
		
		if ($user->RestoreFromSession()) {
			Command::Redirect('ClientCart');
		}
		
		// If action not set
		if (!checkString('act', $_GET)) {
			return $this->RenderDefaultPage();
		}
		$action = $_GET['act'];
		switch ($action) {
			case 'login':
				if (!checkString('login', $_POST) || !checkString('password', $_POST)) {
					return $this->RenderDefaultPage('', $_POST['login']);
				}
				
				$login = $_POST['login'];
				$password = $_POST['password'];
				
				$user = new User();
				if (!$user->Login($login, $password)) {
					return $this->RenderDefaultPage('', $login);
				}
				
				Command::Redirect('ClientCart');
			case 'register':
				$name = $_POST['name'];
				$login = $_POST['login'];
				$password = $_POST['password'];
				$passwordConfirmation = $_POST['confirm_password'];
				
				if ($password != $passwordConfirmation) {
					return $this->RenderDefaultPage($name, $login);
				}
				
				User::CreateUser($login, $password, AccessMode::USER);
				
				$user = new User();
				if (!$user->Login($login, $password)) {
					return $this->RenderDefaultPage('', $login);
				}
				
				$info['organization_type'] = $_POST['organization_type'];
				$info['name'] = $_POST['name'];
				$info['phone'] = $_POST['phone'];
				$user->SetInfo($info);
				
				// TODO: use user instead client
				/*$client = new Client();
				$client->Load(-1);
				$client->Set('access_rights', AccessMode::USER);
				$client->Set('name', $name);
				$client->Set('login', $login);
				$client->Set('password', md5($password));
				$client->Set('last_visit', 'NOW()');
				$client->Set('registered', 'NOW()');
				$client->Save(-1);*/
				
				Command::Redirect('ClientCart');
			case 'recover':
				$login = $_POST['login'];
				
				break;
			default:
				return $this->RenderDefaultPage();
		}
		
		
	}
}
