<?php

class Producer extends Entity {
	public function __construct() {
		parent::__construct(
			'producers',
			'id',
			array(
				'title',
				'short_description'
			)
		);
	}
	
	protected function CloneEntity() {
		return new Producer();
	}
}

?>