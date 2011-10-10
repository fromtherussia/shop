<?php

class Cart {
	public static function RenderItemsCountInput($itemId) {
		?>
		<a href="#" onclick="return false;" id="buy-action">купить</a>
		<span class="hidden" id="buy-amount">		
			Колличество:&nbsp;<input size="10" type="text" class="alright" /><button type="button">купить</button>
		</span>
		<script>
			function hideBuyControls() {
				$('#buy-action').hide();
				$('#buy-amount').hide();
			}
			
			function showBuyAction() {
				hideBuyControls();
				$('#buy-action').fadeIn();
			}
			
			function showCountPicker() {
				hideBuyControls();
				$('#buy-amount').fadeIn();
			}
			
			$('#buy-action').click(function() {
				showCountPicker();
			});
			
			$('#buy-amount button').click(function() {
				amount = $('#buy-amount input').val();
				
				items = $.cookie('LCCartItemIds');
				amounts = $.cookie('LCCartItemAmounts');
				if ($.isValid(items)) {
					amounts +=  ',' + amount;
				} else {
					amounts = amount;
				}
				if ($.isValid(items)) {
					items += ',' + <?= $itemId; ?>;
				} else {
					items = <?= $itemId; ?>;
				}
				$.cookie('LCCartItemIds', items);
				$.cookie('LCCartItemAmounts', amounts);
				
				showBuyAction();
			});
		</script>
		<?php
	}
		
	public static function StoreItemsToDb($clientId) {
		if (!isExists('LCCartItemIds', $_COOKIE) || !isExists('LCCartItemAmounts', $_COOKIE)) {
			return;
		}
		$ids = explode(',', $_COOKIE['LCCartItemIds']);
		$amounts = explode(',', $_COOKIE['LCCartItemAmounts']);
		
		setcookie('LCCartItemIds', '');
		setcookie('LCCartItemAmounts', '');
		
		$sql = "INSERT INTO cart (client_id, product_id, amount) VALUES ";
		$valuesStr = '';
		$isFirst = true;
		foreach ($ids as $no => $id) {
			if (!$isFirst) {
				$valuesStr .= ',';
			}
			$isFirst = false;
			$amount = $amounts[$no];
			$valuesStr .= "($clientId, $id, $amount)";
		}
		if ($valuesStr == '') {
			return;
		}
		echo $sql . $valuesStr;
		update($sql . $valuesStr);
	}
	
	public static function GetDiscountPrecent($price, $type) {
		$precent = fetch_one(select("
			SELECT precent
				FROM discounts
				WHERE $price >= range_begin AND $price <= range_end AND type = $type LIMIT 1;"), 'precent');
		return $precent ? $precent : 0;
	}
	
	public static function GetItemsRetailPrice($clientId, $type) {
		return fetch_one(select("
			SELECT SUM(p.price_retail * c.amount) AS price
				FROM cart c
				INNER JOIN products p ON p.id = c.product_id
				WHERE client_id = $clientId;"), 'price');
	}
	
	public static function GetItemsWholealePrice($clientId, $type) {
		return fetch_one(select("
			SELECT SUM(p.price_wholesale * c.amount) AS price
				FROM cart c
				INNER JOIN products p ON p.id = c.product_id
				WHERE client_id = $clientId;"), 'price');
	}
	
	public static function GetTemporaryItems() {
		if (!isExists('LCCartItemIds', $_COOKIE) || !isExists('LCCartItemAmounts', $_COOKIE)) {
			return;
		}
		setcookie('LCCartItemIds', $_COOKIE['LCCartItemIds']);
		setcookie('LCCartItemAmounts', $_COOKIE['LCCartItemAmounts']);
		
		$ids = explode(',', $_COOKIE['LCCartItemIds']);
		$amounts = explode(',', $_COOKIE['LCCartItemAmounts']);
		$items = array();
		foreach ($ids as $no => $id) {
			$amount = $amounts[$no];
			$item = fetch_row(select("
				SELECT p.title, p.short_description, p.price_retail, p.price_wholesale, p.article
					FROM products p
					WHERE p.id = $id;
			"));
			$item['amount'] = $amount;
			$items[] = $item;
		}
		return $items;
	}
	
	public static function GetItemsPrices($items) {
		$wholesalePrice = 0;
		$retailPrice = 0;
		foreach ($items as $item) {
			$wholesalePrice += $item['price_wholesale'] * $item['amount'];
			$retailPrice += $item['price_retail'] * $item['amount'];
		}
		return array(
			$wholesalePrice,
			$retailPrice
		);
	}
	
	public static function GetItems($clientId) {
		return fetch_all(select("
			SELECT p.title, p.short_description, p.price_retail, p.price_wholesale, p.article, c.amount
				FROM cart c
				INNER JOIN products p ON p.id = c.product_id
				WHERE client_id = $clientId;
		"));
	}
	
	public static function MoveCartToOrder($clientId) {
		$price = Cart::GetItemsPrice($clientId);
		$precent = Cart::GetDiscountPrecent($price);
		$discountedPrice = $price * (1.0 - ($precent / 100.0));
		
		$orderId = fetch_one(select("INSERT INTO cart_order (client_id, status_id, paid, price, price_discounted) VALUES ($clientId, 1, false, $price, $discountedPrice) RETURNING id;"), 'id');
		update("INSERT INTO ordered_products (ordered_id, product_id, amount)
			SELECT $orderId, product_id, amount FROM cart WHERE client_id = $clientId;");
		update("DELETE FROM cart WHERE client_id = $clientId;");
	}
	
	public static function GetOrderedProducts($clientId) {
		return fetch_all(select(
			"SELECT o.id, s.title
				FROM cart_order o
				INNER JOIN cart_order_status s ON s.id = o.status_id
				WHERE o.client_id = $clientId;"
		));
	}
	
	public static function GetOrderProducts($orderId) {
		return fetch_all(select(
			"SELECT o.id, p.article, p.title, op.amount
				FROM cart_order o
				LEFT JOIN ordered_products op ON op.ordered_id = o.id
				INNER JOIN products p ON p.id = op.product_id
				WHERE o.id = $orderId;"
		));
	}
	
	public static function GetOrderProductsByClient($clientId) {
		return fetch_all(select(
			"SELECT o.id, p.article, p.title, op.amount
				FROM cart_order o
				LEFT JOIN ordered_products op ON op.ordered_id = o.id
				INNER JOIN products p ON p.id = op.product_id
				WHERE o.client_id = $clientId
				ORDER BY o.id
				;"
		));
	}
	
	public static function GetAllOrderedProducts() {
		return fetch_all(select(
			"SELECT o.id, s.title
				FROM cart_order o
				INNER JOIN cart_order_status s ON s.id = o.status_id;"
		));
	}
	
	public static function SetOrderStatus($orderId, $statusId) {
		update("UPDATE cart_order SET status_id = $statusId WHERE id = $orderId;");
	}
	
	public static function GetOrderStatus($orderId) {
		return fetch_one(select("SELECT status_id FROM cart_order WHERE id = $orderId;"), 'status_id');
	}
}