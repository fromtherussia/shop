<?php

class Client extends Entity {
	public function __construct() {
		parent::__construct(
			'clients',
			'id',
			array(
				'login',
				'password',
				'phone',
				'name',
				'last_visit',
				'registered',
				'access_rights',
				'comments',
				'organization_type',
				'juridical_address',
				'ogrn',
				'inn',
				'kpp',
				'okpo',
				'mailing_address',
				'current_account',
				'correspondent_account',
				'bik'
			)
		);
	}
	
	protected function CloneEntity() {
		return new Client();
	}
}
