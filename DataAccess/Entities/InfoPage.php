<?php

class InfoPage extends Entity {
	public function __construct() {
		parent::__construct(
			'info_pages',
			'id',
			array(
				'title',
				'info_section_id',
				'order_no',
				'content'
			),
			array(
				'info_section_id' => new InfoSection()
			)
		);
	}
	
	protected function CloneEntity() {
		return new InfoPage();
	}
}

?>