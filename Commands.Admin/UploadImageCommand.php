<?php

class UploadImageCommand extends Command {
	public function __construct () {
		parent::__construct(VIEWER); // WARNING:
	}

	public function Execute() {
		$validationResult = ImageUploader::ValidateImageUpload('image-file');
		$template = new Template('UploadImage');
		if ($validationResult != ImageUploadCode::SUCCESS) {
			$template->SetError(ImageUploadCode::UploadCodeToString($validationResult));
		} else {
			ImageUploader::UploadImage('image-file');
			$template->SetMessage(ImageUploadCode::UploadCodeToString($validationResult));
		}
		$template->Render();
		return true;
	}
}