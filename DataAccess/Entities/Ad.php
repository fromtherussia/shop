<?php

class Ad extends Entity {
	public function __construct() {
		parent::__construct(
			'ads',
			'id',
			array(
				'name',
				'content',
				'from_date',
				'to_date'
			)
		);
	}
	
	public static function GetRandomAd() {
		$adsCount = fetch_one(select("SELECT count(*) AS count FROM ads WHERE NOW() >= from_date AND NOW() <= to_date;"), 'count');
		if ($adsCount < 1) {
			return "";
		}
		$adId = rand(1, $adsCount);
		return fetch_one(select("SELECT content FROM ads WHERE id = $adId;"), 'content');
	}
	
	protected function CloneEntity() {
		return new Ad();
	}
}

?>