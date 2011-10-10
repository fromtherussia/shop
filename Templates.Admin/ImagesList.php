<div>
<?php
	$imageNo = 0;
	foreach ($images as $imageName) {
		$preview = ImageUploader::GetPreviewImage($imageName);
		$normal = ImageUploader::GetNormalImage($imageName);
		?>
			<div class="left image-wrapper">
				<div id="image-preview-<?= $imageNo;?>">&nbsp;</div>
				<script>
					$(function() {
						$('#image-preview-<?= $imageNo; ?>').popupImage({
							'small': '<?= $preview; ?>',
							'large': '<?= $normal; ?>',
							'title': '<?= $imageName; ?>'
						});
					});
				</script>
			</div>
		<?php
		$imageNo++;
	}
?>
<br class="clear" />
</div>