<?php

class GetSearchResultsCommand extends Command {
	public function Execute () {
		if (!array_key_exists('tp', $_GET) || !array_key_exists('q', $_GET) || !array_key_exists('ll', $_GET) || !array_key_exists('ul', $_GET)) {
			return true;
		}
		$type = $_GET['tp'];
		$searchText = $_GET['q'];
		$lowerLimit = $_GET['ll'];
		$upperLimit = $_GET['ul'];
		
		$template = NULL;
		switch ($type) {
			case 'products':
				$template = new Template('FoundProducts');
				$products = Catalog::SearchProducts($searchText, $lowerLimit, $upperLimit);
				$template->SetParam('products', $products);
				break;
			case 'categories':
				$template = new Template('FoundCategories');
				$categories = Catalog::SearchCategories($searchText, $lowerLimit, $upperLimit);
				$template->SetParam('categories', $categories);
				break;
			default:
				return true;
		}
		
		$template->Render();
		return true;
	}
}