<?php

class ClientOrdersCommand extends Command {
	public function Execute () {
		$user = new User();
		if (!$user->RestoreFromSession()) {
			Command::Redirect('ClientLogin');
		}
		$userInfo = $user->GetInfo();
		$userId = $userInfo['id'];
		$orderedProducts = Cart::GetOrderedProducts($userId);
		
		$ordersTemplate = new Template('ClientOrders');
		$ordersTemplate->SetParam('orderedProducts', $orderedProducts);
		wrapClientPanelTemplate('Все заказы', $ordersTemplate);
		return true;
	}
}