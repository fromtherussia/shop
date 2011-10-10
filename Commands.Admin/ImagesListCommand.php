<?php

class ImagesListCommand extends Command {
	public function __construct () {
		parent::__construct(VIEWER); // WARNING:
	}

	public function Execute() {
		$images = ImageUploader::ListImages(getcwd() . '/' . ImageUploader::GetImagePrefix(ImageScale::SMALL));
		$template = new Template('ImagesList');
		$template->SetParam('images', $images);
		$template->Render();
		return true;
	}
}