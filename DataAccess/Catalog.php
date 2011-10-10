<?php

define('CATALOG_FOUND_PRODUCTS_PER_PAGE', 10);
define('CATALOG_FOUND_CATEGORIES_PER_PAGE', 10);

class Catalog {
	public static function GetCategoriesTree () {
		$categories = fetch_all(select("
			SELECT t.category_id, t.parent_category_id, c.title, c.short_description
				FROM categories_tree t
				INNER JOIN categories c ON c.id = t.category_id;
		"));
		$rootId = Catalog::GetCategoriesRoot();
		
		$result = array();
		
		foreach ($categories as $category) {
			$parentId = $category['parent_category_id'];
			$currentId = $category['category_id'];
			if (!array_key_exists($currentId, $result)) {
				$result[$currentId] = array();
			}
			$result[$currentId]['data'] = $category;
			
			if (!array_key_exists($parentId, $result)) {
				$result[$parentId] = array();
				$result[$parentId]['children'] = array();
			}
			$result[$parentId]['children'][] = &$result[$currentId];
		}
		
		$out = array();
		foreach ($categories as $category) {
			$parentId = $category['parent_category_id'];
			$currentId = $category['category_id'];
			if ($parentId == $rootId) {
				$out[] = $result[$currentId];
			}
		}
	
		return $out;
	}
	
	public static function GetCategoriesRoot () {
		$rootId = fetch_one(select("SELECT getCategoriesRoot() AS root_id;"), "root_id");
		return $rootId >= 0 ? $rootId : -1;
	}
	
	public static function HasSubcategories ($categoryId) {
		$subrategoriesCount = fetch_one(select("
			SELECT count(*) AS subcategories_count 
				FROM categories_tree WHERE parent_category_id = $categoryId;"), "subcategories_count");
		return $subrategoriesCount > 0;
	}
	
	public static function GetSubcategoriesForRootCategories ($rootCategories) {
		$rootCategoriesIds = array();
		
		foreach ($rootCategories as $category) {
			$rootCategoriesIds[] = $category['id'];
		}
		$rootCategoriesIds = '(' . implode(',', $rootCategoriesIds) . ')';
		return fetch_all(select("
			SELECT c.*, t.parent_category_id
				FROM categories_tree t 
				INNER JOIN categories c ON c.id = t.category_id AND t.parent_category_id IN $rootCategoriesIds;"));
	}
	
	public static function GetSubcategories ($categoryId = -1) {
		if ($categoryId == -1) {
			$categoryId = Catalog::GetCategoriesRoot();
		}
		return fetch_all(select("
			SELECT c.* 
				FROM categories_tree t 
				INNER JOIN categories c ON c.id = t.category_id AND t.parent_category_id = $categoryId;"));
	}
	
	public static function GetProductsInCategory ($categoryId) {
		return fetch_all(select("
			SELECT p.*
				FROM products p
				WHERE p.category_id = $categoryId;"));
	}
	
	public static function GetProductInfo ($productId) {
		return fetch_row(select("SELECT p.* FROM products p WHERE p.id = $productId;"));
	}
	
	public static function GetProductImages ($productId) {
		$images = fetch_all(select("SELECT image_url FROM product_images i WHERE i.product_id = $productId;"));
		foreach ($images as &$image) {
			$image = $image['image_url'];
		}
		return $images;
	}
	
	public static function GetCategoryInfo ($categoryId) {
		return fetch_row(select("
			SELECT c.*, t.parent_category_id
				FROM categories c
				INNER JOIN categories_tree t ON t.category_id = c.id AND c.id = $categoryId;"));
	}
	
	public static function GetCategoryPath ($parentCategoryId, $categoryId, $categoryTitle, $categoryDescription) {
		return fetch_all(select("
			SELECT parent_id, 
				category_id, 
				title, 
				short_description 
				FROM getCategoryPath($parentCategoryId, $categoryId, '$categoryTitle', '$categoryDescription') 
					AS path(parent_id BIGINT, category_id BIGINT, title TEXT, short_description TEXT);"));
	}
	
	public static function SearchProducts($searchText, $lowerLimit, $upperLimit) {
		$searchText = allLower($searchText);
		$limit = $upperLimit - $lowerLimit;
		return fetch_all(select("
			SELECT
					p.id,
					p.category_id,
					p.title,
					p.short_description,
					(SELECT count(*)
						FROM product_keywords pk
						LEFT JOIN keywords k ON pk.keyword_id = k.id AND lower(k.keyword) LIKE '%$searchText%'
						WHERE pk.product_id = p.id) AS count_keywords
				FROM products p
				WHERE (lower(p.title) LIKE '%$searchText%') OR 
					(SELECT count(*)
						FROM product_keywords pk
						LEFT JOIN keywords k ON pk.keyword_id = k.id AND lower(k.keyword) LIKE '%$searchText%'
						WHERE pk.product_id = p.id) > 0
				ORDER BY count_keywords DESC
				LIMIT $limit
				OFFSET $lowerLimit;"));
	}
	
	public static function SearchCategories($searchText, $lowerLimit, $upperLimit) {
		$searchText = allLower($searchText);
		$limit = $upperLimit - $lowerLimit;
		return fetch_all(select("
			SELECT
					c.id,
					c.title,
					c.short_description,
					(SELECT count(*)
						FROM category_keywords ck
						LEFT JOIN keywords k ON ck.keyword_id = k.id AND lower(k.keyword) LIKE '%$searchText%'
						WHERE ck.category_id = c.id) AS count_keywords
				FROM categories c
				WHERE (lower(c.title) LIKE '%$searchText%') OR 
					(SELECT count(*)
						FROM category_keywords ck
						LEFT JOIN keywords k ON ck.keyword_id = k.id AND lower(k.keyword) LIKE '%$searchText%'
						WHERE ck.category_id = c.id) > 0
				ORDER BY count_keywords DESC
				LIMIT $limit
				OFFSET $lowerLimit;"));
	}
}