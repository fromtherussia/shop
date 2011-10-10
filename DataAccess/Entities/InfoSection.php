<?php

class InfoSection extends Entity {
	public function __construct() {
		parent::__construct(
			'info_sections',
			'id',
			array(
				'title',
				'order_no'
			)
		);
	}
	
	protected function CloneEntity() {
		return new InfoSection();
	}
}

?>