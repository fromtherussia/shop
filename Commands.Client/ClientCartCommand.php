<?php

class ClientCartCommand extends Command {
	public function __construct() {
		parent::__construct(AccessMode::VIEWER);
	}
	
	public function Execute () {
		$cartTemplate = new Template('ClientCart');
		
		$user = new User();
		
		if (!$user->RestoreFromSession()) {
			$products = ShopPlugin\Cart::GetTemporaryCartProducts();
			$userType = ShopPlugin\Client::TYPE_UNKNOWN;
		} else {
			$userInfo = $user->GetInfo();

			$userType = $userInfo['organization_type'];
			$products = ShopPlugin\Cart::GetStoredCartProducts($userInfo['id']);
		}

		// Calculate prices and precents

		if ($userType == ShopPlugin\Client::TYPE_UNKNOWN || $userType == ShopPlugin\Client::TYPE_JURIDICAL_PERSON) {
			$priceWholesale = ShopPlugin\Cart::CalculatePrice($products, ShopPlugin\Cart::PRICE_TYPE_WHOLESALE);
			$precentWholesale = ShopPlugin\Cart::GetDiscountPrecent($priceWholesale, ShopPlugin\Cart::PRICE_TYPE_WHOLESALE);
			$priceDiscountedWholesale = ShopPlugin\Cart::CalculateDiscountedPrice($priceWholesale, $precentWholesale);

			$cartTemplate->SetParam('priceWholesale', $priceWholesale);
			$cartTemplate->SetParam('precentWholesale', $precentWholesale);
			$cartTemplate->SetParam('priceDiscountedWholesale', $priceDiscountedWholesale);
		}
		
		if ($userType == ShopPlugin\Client::TYPE_UNKNOWN || $userType == ShopPlugin\Client::TYPE_INDIVIDUAL_PERSON) {
			$priceRetail = ShopPlugin\Cart::CalculatePrice($products, ShopPlugin\Cart::PRICE_TYPE_RETAIL);
			$precentRetail = ShopPlugin\Cart::GetDiscountPrecent($priceRetail, ShopPlugin\Cart::PRICE_TYPE_RETAIL);
			$priceDiscountedRetail = ShopPlugin\Cart::CalculateDiscountedPrice($priceRetail, $precentRetail);
			
			$cartTemplate->SetParam('priceRetail', $priceRetail);
			$cartTemplate->SetParam('precentRetail', $precentRetail);
			$cartTemplate->SetParam('priceDiscountedRetail', $priceDiscountedRetail);
		}

		$cartTemplate->SetParam('userType', $userType);
		$cartTemplate->SetParam('products', $products);
		
		if ($userType == ShopPlugin\Client::TYPE_UNKNOWN) {
			wrapSubpageTemplate('Мой заказ', 1, $cartTemplate)->Render();;
		} else {
			wrapClientPanelTemplate('Мой заказ', $cartTemplate);
		}
		return true;
	}
}