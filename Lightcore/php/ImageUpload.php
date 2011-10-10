<?php

/*
	Image scales
*/

class ImageScale {
	const ICON = 1;
	const SMALL = 2;
	const PREVIEW = 3;
	const NORMAL = 4;
	const ORIGINAL = 5;
	
	public static function GetScalePrefix($scaleId) {
		switch ($scaleId) {
			case ImageScale::ICON:
				return 'icon';
			case ImageScale::SMALL:
				return 'small';
			case ImageScale::PREVIEW:
				return 'preview';
			case ImageScale::NORMAL:
				return 'normal';
			case ImageScale::ORIGINAL:
				return 'original';
		}
		return 'undefined';
	}
	
	public static function GetImageDimensions($scaleId) {
		$width = 0;
		$height = 0;
		switch ($scaleId) {
			case ImageScale::ICON:
				$width = 64;
				$height = 64;
				break;
			case ImageScale::SMALL:
				$width = 100;
				$height = 75;
				break;
			case ImageScale::PREVIEW:
				$width = 200;
				$height = 150;
				break;
			case ImageScale::NORMAL:
				$width = 800;
				$height = 600;
				break;
			case ImageScale::ORIGINAL:
				$width = 0;
				$height = 0;
				break;
		}
		$result = array($width, $height);
		return $result;	
	}
}

class ImageUploadCode {
	const SUCCESS = 0;
	const DOESNT_UPLOADED = 1;
	const INVALID_TYPE = 2;
	const INVALID_SIZE = 3;
	const UPLOADING_eRROR = 4;
	const ALREADY_eXISTS = 5;
	
	public static function UploadCodeToString($uploadCode) {
		switch ($uploadCode) {
			case ImageUploadCode::SUCCESS:
				return "Файл успешно загружен.";
			case ImageUploadCode::DOESNT_UPLOADED:
				return "Ошибка загрузки файла.";
			case ImageUploadCode::INVALID_TYPE:
				return "Недопустимое расширение файла. Расширение должно быть jpg, gif или png.";
			case ImageUploadCode::INVALID_SIZE:
				return "Размера файла превышает 2МБ.";
			case ImageUploadCode::UPLOADING_eRROR:
				return "Ошибка загрузки файла.";
			case ImageUploadCode::ALREADY_eXISTS:
				return "Файл с таким именем уже загружен.";
		}
		return "Ошибка загрузки файла.";
	}
}

class ImageUploader {
	private static $m_imagesPath = '';
	
	private static function CompressImages($image) {
		$originalImage = self::GetOriginalImage($image);
		self::ScaleImage($originalImage, self::GetNormalImage($image), ImageScale::GetImageDimensions(ImageScale::NORMAL));
		self::ScaleImage($originalImage, self::GetPreviewImage($image), ImageScale::GetImageDimensions(ImageScale::PREVIEW));
		self::ScaleImage($originalImage, self::GetSmallImage($image), ImageScale::GetImageDimensions(ImageScale::SMALL));
		self::ScaleImage($originalImage, self::GetIconImage($image), ImageScale::GetImageDimensions(ImageScale::ICON));
	}
	
	private function GetTodayPrefix() {
		static $todayPrefix = '';
		if ($todayPrefix == '') {
			$todayPrefix = date("Ymd");
		}
		return $todayPrefix;
	}
	
	private function ScaleImage($sourceFileName, $destinationFileName, $dimensions) {
		list($maxWidth, $maxHeight) = $dimensions;
		
		$image_info = getimagesize($sourceFileName);
		
		$originalImage = null;
		$imageType = $image_info[2];
		list($originalWidth, $originalHeight) = getimagesize($sourceFileName);
		
		switch ($imageType) {
			case IMAGETYPE_JPEG:		
				$originalImage = imagecreatefromjpeg($sourceFileName);
				break;
			case IMAGETYPE_GIF:
				$originalImage = imagecreatefromgif($sourceFileName);
				break;
			case IMAGETYPE_PNG:
				$originalImage = imagecreatefrompng($sourceFileName);
				break;
		}

		$originalAspectRaito = $originalWidth / $originalHeight;
		$requestedAspectRaito = $maxWidth / $maxHeight;

		$newImage = null;
		$newWidth = 0;
		$newHeight = 0;

		if ($originalAspectRaito > $requestedAspectRaito) {
			$newWidth = $maxWidth;
			$newHeight = $maxWidth / $originalAspectRaito;
			$newImage = imagecreatetruecolor($newWidth, $newHeight);
		} else {
			$newWidth = $maxHeight * $originalAspectRaito;
			$newHeight = $maxHeight;
			$newImage = imagecreatetruecolor($newWidth, $newHeight);
		}

		imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
		switch ($imageType) {
			case IMAGETYPE_JPEG:		
				imagejpeg($newImage, $destinationFileName, 100);
				break;
			case IMAGETYPE_GIF:
				imagegif($newImage, $destinationFileName, 100);
				break;
			case IMAGETYPE_PNG:
				imagepng($newImage, $destinationFileName, 100);
				break;
		}
	}
	
	private static function GetImageScalePrefix($scaleId) {
		return self::$m_imagesPath . '/' . ImageScale::GetScalePrefix($scaleId) . '/';
	}

	// Public interface.
	
	public static function GetImagePrefix($scaleId) {
		return self::GetImageScalePrefix($scaleId) . self::GetTodayPrefix() . '/';
	}
	
	public static function SetImagesPath($imagesPath) {
		self::$m_imagesPath = $imagesPath;
		
		if (!file_exists(self::GetImageScalePrefix(ImageScale::ORIGINAL))) {
			mkdir(self::GetImageScalePrefix(ImageScale::ORIGINAL));
			mkdir(self::GetImageScalePrefix(ImageScale::NORMAL));
			mkdir(self::GetImageScalePrefix(ImageScale::PREVIEW));
			mkdir(self::GetImageScalePrefix(ImageScale::SMALL));
			mkdir(self::GetImageScalePrefix(ImageScale::ICON));
		}
		
		if (!file_exists(self::GetImagePrefix(ImageScale::ORIGINAL))) {
			mkdir(self::GetImagePrefix(ImageScale::ORIGINAL));
			mkdir(self::GetImagePrefix(ImageScale::NORMAL));
			mkdir(self::GetImagePrefix(ImageScale::PREVIEW));
			mkdir(self::GetImagePrefix(ImageScale::SMALL));
			mkdir(self::GetImagePrefix(ImageScale::ICON));
		}
	}
	
	
	public static function ValidateImageUpload($imageName) {
		if (!array_key_exists($imageName, $_FILES)) {
			return ImageUploadCode::DOESNT_UPLOADED;
		}
		
		// Validate
		$type = $_FILES[$imageName]["type"];
		$size = $_FILES[$imageName]["size"];
		$error = $_FILES[$imageName]["error"];
		
		if ($type != "image/gif" && $type != "image/jpeg" && $type != "image/png") {
			return ImageUploadCode::INVALID_TYPE;
		}
		
		if ($size > 2000000) {
			return ImageUploadCode::INVALID_SIZE;
		}
		
		if ($error > 0) {
			return ImageUploadCode::UPLOADING_eRROR;
		}
		
		return ImageUploadCode::SUCCESS;
	}
	
	public static function UploadImage($imageName) {
		$uploadedImageName = $_FILES[$imageName]["name"];
		move_uploaded_file($_FILES[$imageName]["tmp_name"], self::GetImagePrefix(ImageScale::ORIGINAL) . $uploadedImageName);
		self::CompressImages($uploadedImageName);
		return $uploadedImageName;
	}
	
	public static function GetUploadedImage($imageName, $scale, $isForToday) {
		if ($isForToday) {
			return self::GetImagePrefix($scale) . $imageName;
		}
		return self::GetImageScalePrefix($scale) . $imageName;
	}
	
	public static function GetOriginalImage($imageName, $isForToday = true) {
		return self::GetUploadedImage($imageName, ImageScale::ORIGINAL, $isForToday);
	}
	
	public static function GetNormalImage($imageName, $isForToday = true) {
		return self::GetUploadedImage($imageName, ImageScale::NORMAL, $isForToday);
	}
	
	public static function GetPreviewImage($imageName, $isForToday = true) {
		return self::GetUploadedImage($imageName, ImageScale::PREVIEW, $isForToday);
	}
	
	public static function GetSmallImage($imageName, $isForToday = true) {
		return self::GetUploadedImage($imageName, ImageScale::SMALL, $isForToday);
	}
	
	public static function GetIconImage($imageName, $isForToday = true) {
		return self::GetUploadedImage($imageName, ImageScale::ICON, $isForToday);
	}
	
	public static function ListImages($path) {
		$files = array();
		$foundEntries = scandir($path);
		if (count($foundEntries) > 2) {
			foreach ($foundEntries as $entry) {
				if ($entry != '.' && $entry != '..') {
					if (!is_dir($path . '/' . $entry)) {
						$files[] = $entry;
					}
				}
			}
		}
		return $files;
	}
}
