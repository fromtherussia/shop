<?php

namespace ShopPlugin;

class Cart {
	const PRICE_TYPE_RETAIL = 1;
	const PRICE_TYPE_WHOLESALE = 2;

	public static function RenderProductsAmountPicker($productId) {
		$buyControlId = 'cms-plugin-shop-buy-control-' . $productId . '-' . rand();
		$amountInputId = 'cms-plugin-shop-amount-input-' . $productId . '-' . rand();
	?>
		<span class="cms-plugin-shop-pick-amount">
			<a href="#" onclick="return false;" id="<?= $buyControlId; ?>">купить</a>
			<span class="hidden" id="<?= $amountInputId; ?>">		
				Колличество:&nbsp;<input size="10" type="text" class="alright" /><button type="button">купить</button>
			</span>
		</span>
		<script>
			$(function() {
				function hideBuyControls() {
					$('#<?= $buyControlId; ?>').hide();
					$('#<?= $amountInputId; ?>').hide();
				}

				function showBuyControl() {
					hideBuyControls();
					$('#<?= $buyControlId; ?>').fadeIn();
				}

				function showAmountPicker() {
					hideBuyControls();
					$('#<?= $amountInputId; ?>').fadeIn();
				}

				$('#<?= $buyControlId; ?>').click(function() {
					showAmountPicker();
				});

				$('#<?= $amountInputId; ?> button').click(function() {
					amount = $('#<?= $amountInputId; ?> input').val();

					items = $.cookie('CMSPCartItemIds');
					amounts = $.cookie('CMSPCartItemAmounts');

					if ($.isValid(items)) {
						items += ',' + <?= $productId; ?>;
						amounts +=  ',' + amount;
					} else {
						items = <?= $productId; ?>;
						amounts = amount;
					}

					$.cookie('CMSPCartItemIds', items);
					$.cookie('CMSPCartItemAmounts', amounts);

					showBuyControl();
				});
			});
		</script>
	<?php
	}
	
	private static function StoreTemporaryProducts($clientId) {
		$temporaryProducts = self::GetTemporaryCartProducts();
		if (count($temporaryProducts) == 0) {
			return;
		}
		
		$sql = "INSERT INTO cart (client_id, product_id, amount) VALUES ";
		$valuesStr = '';
		$isFirst = true;
		foreach ($temporaryProducts as $temporaryProduct) {
			if (!$isFirst) {
				$valuesStr .= ',';
			}
			$isFirst = false;

			$amount = $temporaryProduct['amount'];
			$id = $temporaryProduct['id'];
			$valuesStr .= "($clientId, $id, $amount)";
		}
		if ($valuesStr == '') {
			return;
		}
		update($sql . $valuesStr);
	}
	
	public static function GetTemporaryCartProducts() {
		$items = array();
		if (!isExists('CMSPCartItemIds', $_COOKIE) || !isExists('CMSPCartItemAmounts', $_COOKIE)) {
			return $items;
		}

		setcookie('CMSPCartItemIds', $_COOKIE['CMSPCartItemIds']);
		setcookie('CMSPCartItemAmounts', $_COOKIE['CMSPCartItemAmounts']);

		$productIds = explode(',', $_COOKIE['CMSPCartItemIds']);
		$amounts = explode(',', $_COOKIE['CMSPCartItemAmounts']);

		foreach ($productIds as $orderNo => $productId) {
			$item = fetch_row(select("
				SELECT p.id, p.title, p.short_description, p.price_retail, p.price_wholesale, p.article
					FROM products p
					WHERE p.id = $productId;
			"));
			$item['amount'] = $amounts[$orderNo]; // Adding items amount
			$items[] = $item;
		}
		return $items;
	}
	
	public static function GetStoredCartProducts($clientId) {
		// Store temporary products to db
		self::StoreTemporaryProducts($clientId);

		// Requesting all products from db
		return fetch_all(select("
			SELECT p.id, p.title, p.short_description, p.price_retail, p.price_wholesale, p.article, c.amount
				FROM cart c
				INNER JOIN products p ON p.id = c.product_id
				WHERE client_id = $clientId;
		"));
	}
	
	public static function CalculatePrice($items, $type) {
		switch ($type) {
			case Cart::PRICE_TYPE_RETAIL:
				$retailPrice = 0;
				foreach ($items as $item) {
					$retailPrice += $item['price_retail'] * $item['amount'];
				}
				return $retailPrice;
			case Cart::PRICE_TYPE_WHOLESALE:
				$wholesalePrice = 0;
				foreach ($items as $item) {
					$wholesalePrice += $item['price_wholesale'] * $item['amount'];
				}
				return $wholesalePrice;
			default:
				return 0;
		}
	}
	
	public static function GetDiscountPrecent($price, $type) {
		switch ($type) {
			case Cart::PRICE_TYPE_RETAIL:
				$priceType = 2;
				break;
			case Cart::PRICE_TYPE_WHOLESALE:
				$priceType = 1;
				break;
		}

		$precent = fetch_one(select("
			SELECT precent
				FROM discounts
				WHERE $price >= range_begin
					AND $price <= range_end
					AND type = $priceType
				LIMIT 1;
		"), 'precent');
		return $precent ? $precent : 0;
	}
	
	public static function CalculateDiscountedPrice($price, $discountPrecent) {
		return $price * (1.0 - ($discountPrecent / 100.0));
	}
}
