<?php

class Discounts {
	public static function GetWholesaleDiscounts() {
		return fetch_all(select("SELECT precent, range_begin, range_end FROM discounts WHERE type = 1 ORDER BY precent;"));
	}
	
	public static function SetWholesaleDiscounts($discounts) {
		update("DELETE FROM discounts WHERE type = 1;");
		$insertValuesStr = '';
		$isFirst = true;
		foreach ($discounts as $discount) {
			if (!$isFirst) {
				$insertValuesStr .= ',';
			}
			$isFirst = false;
			
			$precent = $discount['precent'];
			$rangeBegin = $discount['rangeBegin'];
			$rangeEnd = $discount['rangeEnd'];
			$insertValuesStr .= "($precent, $rangeBegin, $rangeEnd, 1)";
		}
		update("INSERT INTO discounts (precent, range_begin, range_end, type) VALUES $insertValuesStr;");
	}
	
	public static function GetRetailDiscounts() {
		return fetch_all(select("SELECT precent, range_begin, range_end FROM discounts WHERE type = 2 ORDER BY precent;"));
	}
	
	public static function SetRetailDiscounts($discounts) {
		echo "SetRetailDiscounts";
		update("DELETE FROM discounts WHERE type = 2;");
		$insertValuesStr = '';
		$isFirst = true;
		foreach ($discounts as $discount) {
			if (!$isFirst) {
				$insertValuesStr .= ',';
			}
			$isFirst = false;
			
			$precent = $discount['precent'];
			$rangeBegin = $discount['rangeBegin'];
			$rangeEnd = $discount['rangeEnd'];
			$insertValuesStr .= "($precent, $rangeBegin, $rangeEnd, 2)";
		}
		update("INSERT INTO discounts (precent, range_begin, range_end, type) VALUES $insertValuesStr;");
	}
}