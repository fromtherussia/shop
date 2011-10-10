<?php

class Category extends Entity {
	public function __construct() {
		parent::__construct(
			'categories',
			'id',
			array(
				'title',
				'image',
				'short_description',
				'long_description',
				'published'
			)
		);
	}
	
	protected function CloneEntity() {
		return new Category();
	}
	
	public function GetParentCategoryTitle() {
		$categoryId = $this->GetPkValue();
		return fetch_one(
			select("
				SELECT c.title AS title
					FROM categories_tree ct
					INNER JOIN categories c ON c.id = ct.parent_category_id
					WHERE ct.category_id = $categoryId
					LIMIT 1;
			"), 
			'title'
		);
	}
	
	public function GetSubcategoriesCount() {
		$categoryId = $this->GetPkValue();
		return fetch_one(select("SELECT count(*) AS categories_count FROM categories_tree WHERE parent_category_id = $categoryId;"), 'categories_count');
	}
	
	public function GetProductsCount() {
		$categoryId = $this->GetPkValue();
		return fetch_one(select("SELECT count(*) AS products_count FROM products WHERE category_id = $categoryId;"), 'products_count');
	}
}

?>