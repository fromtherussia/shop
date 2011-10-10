<?php

class ClientOrderCommand extends Command {
	public function Execute () {
		$orderProducts = Cart::GetOrderProducts($_GET['id']);
		$ordersTemplate = new Template('ClientOrder');
		$ordersTemplate->SetParam('orderProducts', $orderProducts);
		wrapClientPanelTemplate('Все заказы', $ordersTemplate);
		return true;
	}
}