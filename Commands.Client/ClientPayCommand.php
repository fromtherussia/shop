<?php

class ClientPayCommand extends Command {
	public function Execute () {
		$user = new User();
		if (!$user->RestoreFromSession()) {
			Command::Redirect('ClientLogin');
		}
		
		$userInfo = $user->GetInfo();
		$userId = $userInfo['id'];
		
		$payTemplate = new Template('ClientPay');
		wrapClientPanelTemplate('Оплата заказа', $payTemplate);
		return true;
	}
}