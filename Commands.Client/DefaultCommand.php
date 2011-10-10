<?php

class DefaultCommand extends Command {
	public function Execute () {
		echo "default command!";
		return true;
	}
}