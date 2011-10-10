<?php

class NamedArticle extends Entity {
	public function __construct() {
		parent::__construct(
			'named_articles',
			'id',
			array(
				'article_location_id',
				'name',
				'content'
			),
			array(
				'article_location_id' => new ArticleLocation()
			)
		);
	}
	
	public static function GetArticleByLocation($articleLocationName) {
		return fetch_row(select("
			SELECT na.name, na.content
				FROM named_articles na
				INNER JOIN article_locations al ON na.article_location_id = al.id
				WHERE al.name = '$articleLocationName'
				ORDER BY na.id ASC
				LIMIT 1;"), 'content');
	}
	
	public static function GetArticlesByLocation($articleLocationName) {
		return fetch_all(select("
			SELECT na.name, na.content
				FROM named_articles na
				INNER JOIN article_locations al ON na.article_location_id = al.id
				WHERE al.name = '$articleLocationName'
				ORDER BY na.id ASC;"));
	}
	
	protected function CloneEntity() {
		return new NamedArticle();
	}
}

?>