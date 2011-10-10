<?php

class CatalogCommand extends Command {

	private static function PrepareCategoriesTree (&$categoriesTree) {
		foreach ($categoriesTree as &$category) {
			$category['tree_item_name'] = firstUpper($category['data']['title']);
			$category['tree_item_title'] = firstUpper($category['data']['short_description']);
			$category['tree_item_id'] = $category['data']['category_id'];
			$subcategoryId = firstUpper($category['data']['category_id']);
			$category['tree_item_href'] = getCategoryUrl($subcategoryId);
			if (array_key_exists('children', $category)) {
				$category['tree_item_subnodes'] = &$category['children'];
				CatalogCommand::PrepareCategoriesTree($category['children']);
			}
		}
		return $categoriesTree;
	}
	
	private static function GetCategoryIdFromRequest () {
		if (array_key_exists('cat', $_GET)) {
			return $_GET['cat'];
		} else {
			// ≈сли не указана категори€ - переходим на главную каталога
			Command::Redirect('Catalog');
		}
	}
	
	private static function GetProductIdFromRequest() {
		if (array_key_exists('prod', $_GET)) {
			return $_GET['prod'];
		} else {
			// ≈сли не указан продукт - переходим на главную каталога
			Command::Redirect('Catalog');
		}
	}
	
	private static function GetSearchTextFromRequest () {
		if (array_key_exists('q', $_POST)) {
			return $_POST['q'];
		} else {
			// ≈сли не указана категори€ - переходим на главную каталога
			Command::Redirect('Catalog');
		}
	}
	
	public function Execute () {
		$action = 'general-list';
		if (array_key_exists('act', $_GET)) {
			$action = $_GET['act'];
		}
		
		$categoriesTree = Catalog::GetCategoriesTree();
		CatalogCommand::PrepareCategoriesTree($categoriesTree);
		
		$catalogTemplate = new Template('Catalog');
		$catalogTemplate->SetParam('categories_tree', $categoriesTree);
		
		$categoryId = -1;
		
		$template = NULL;
		switch ($action) {
			case 'general-list': // √лавна€ страница каталога со списком корневых категорий
				$template = new Template('GeneralCategories');
				$rootCategories = Catalog::GetSubcategories();
				$template->SetParam('root_categories', $rootCategories);
				if (count($rootCategories) > 0) {
					$subcategories = Catalog::GetSubcategoriesForRootCategories($rootCategories);
					$template->SetParam('subcategories', $subcategories);
				}
				break;
			case 'subcategories-list': // —траница подкатегории
				$categoryId = CatalogCommand::GetCategoryIdFromRequest();
				if (Catalog::HasSubcategories($categoryId)) {
					$template = new Template('Subcategories');
					$categories = Catalog::GetSubcategories($categoryId);
					$template->SetParam('subcategories', $categories);
				} else {
					$template = new Template('ListProducts');
					$products = Catalog::GetProductsInCategory($categoryId);
					$template->SetParam('products', $products);
					$template->SetParam('category_id', $categoryId);
				}
				break;
			case 'product-info':
				$template = new Template('ProductInfo');				
				$categoryId = CatalogCommand::GetCategoryIdFromRequest();
				$productId = CatalogCommand::GetProductIdFromRequest();
				$product = Catalog::GetProductInfo($productId);
				$images = Catalog::GetProductImages($productId);
				$template->SetParam('product', $product);
				$template->SetParam('images', $images);
				break;
			case 'search':
				$template = new Template('SearchResults');
				$searchText = CatalogCommand::GetSearchTextFromRequest();
				$products = Catalog::SearchProducts($searchText, 0, CATALOG_FOUND_PRODUCTS_PER_PAGE);
				$categories = Catalog::SearchCategories($searchText, 0, CATALOG_FOUND_CATEGORIES_PER_PAGE);
				
				$foundProductsTemplate = new Template('FoundProducts');
				$foundProductsTemplate->SetParam('products', $products);
				$foundCategoriesTemplate = new Template('FoundCategories');
				$foundCategoriesTemplate->SetParam('categories', $categories);
				
				$template->SetParam('found_products_template', $foundProductsTemplate);
				$template->SetParam('found_categories_template', $foundCategoriesTemplate);
				$template->SetParam('products_lower_limit', 0);
				$template->SetParam('categories_lower_limit', 0);
				
				$template->SetParam('search_text', $searchText);
				
				$catalogTemplate->SetParam('search_text', $searchText);
				break;
			default:
				Command::Redirect('Catalog');
				break;
		}
		
		if ($categoryId != -1) {
			$categoryInfo = Catalog::GetCategoryInfo($categoryId);
			$categoryPath = Catalog::GetCategoryPath(
				$categoryInfo['parent_category_id'],
				$categoryInfo['id'], 
				$categoryInfo['title'], 
				$categoryInfo['short_description']
			);
			$catalogTemplate->SetParam('category', $categoryInfo);
			$catalogTemplate->SetParam('path', $categoryPath);
			$catalogTemplate->SetParam('opened_category', $categoryId);
		}
		
		$catalogTemplate->SetParam('page_template', $template);
		wrapSubpageTemplate(' аталог', 1, $catalogTemplate)->Render();
		return true;
	}
}