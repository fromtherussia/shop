<?php

class AdminCommand extends Command {
	public function __construct() {
		parent::__construct(VIEWER);
	}
	
	public function Execute () {
		$user = new User();
		if ($user->RestoreFromSession()) {
			Command::Redirect('AdminEditWholesaleDiscounts');
			return true;
		}
		Command::Redirect('AdminLogin');
		return true;
	}
}