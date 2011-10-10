<?php

class ArticleLocation extends Entity {
	public function __construct() {
		parent::__construct(
			'article_locations',
			'id',
			array(
				'name',
				'title'
			)
		);
	}
	
	protected function CloneEntity() {
		return new ArticleLocation();
	}
}

?>