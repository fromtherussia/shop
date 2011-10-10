<?php

class ProductImages extends Entity {
	public function __construct() {
		parent::__construct(
			'product_images',
			'product_id',
			array(
				'image_url'
			)
		);
	}
	
	protected function CloneEntity() {
		return new ProductImages();
	}
}

class Product extends Entity {
	public function __construct() {
		parent::__construct(
			'products',
			'id',
			array(
				'category_id',
				'producer_id',
				'title',
				'price_wholesale',
				'price_retail',
				'article',
				'short_description',
				'long_description',
				'published',
				'hits'
			),
			array(
				'category_id' => new Category(),
				'producer_id' => new Producer()
			)
		);
	}
	
	protected function CloneEntity() {
		return new Product();
	}
}

?>