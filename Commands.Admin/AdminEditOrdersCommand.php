<?php

class AdminEditOrdersCommand extends Command {
	public function __construct () {
		parent::__construct(VIEWER);
	}
	
	public function Execute() {
		if (checkNumeric('id', $_GET)) {
			$id = escapeSqlSpecialChars($_GET['id']);
			/*$client = new Client();
			$client->Load($id);
			
			// DIRTY:
			$template->SetParam('orders', Cart::GetOrderedProducts($id));
			$template->SetParam('orderProducts', Cart::GetOrderProductsByClient($id));
			*/
			if (checkNumeric('status_id', $_POST)) {
				Cart::SetOrderStatus($id, $_POST['status_id']);
			}
			$statusId = Cart::GetOrderStatus($id);
			
			$template = new Template('AdminEditOrders.Edit');
			$template->SetParam('orderProducts', Cart::GetOrderProducts($id));
			$template->SetParam('id', $id);
			$template->SetParam('statusId', $statusId);
		} else {
			$template = new Template('AdminEditOrders.List');
			$template->SetParam('orders', Cart::GetAllOrderedProducts());
		}
		wrapAdminTemplate('Êëèåíòû', 7, $template, false)->Render();
		return true;
	}
};