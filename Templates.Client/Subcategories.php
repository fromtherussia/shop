<style>
	#subcategories-list .category {
		width: 190px;
		min-height: 220px;
		padding: 15px;
		border: 1px solid transparent;
	}

	#subcategories-list .category:hover {
		border: 1px solid #ccc;
		background-color: #ddd;
	}

	#subcategories-list .category div.imagep img {
		max-width: 98px;
		max-height: 64px;
	}

	#subcategories-list .category div.imagep {
		width: 100px;
		height: 66px;
		border: 1px solid black;
		background-color: #fff;
	}
</style>
<div id="subcategories-list">
	<?php
		$localId = 0;
		foreach ($subcategories as $subcategory) {
			$image = safeGetItem('image', $subcategory, '');
			$shortDescription = safeGetItem('short_description', $subcategory, 'Описание отсутствует');
			$title = safeGetItem('title', $subcategory, 'Без названия');
			
			$href = getCategoryUrl($subcategory['id']);
			$subcategoryImageId = 'subcategory-image-' . $localId;
	?>
			<div class="category left">
				<div id="<?= $subcategoryImageId; ?>" class="imagep">&nbsp;</div>
				<h4><a href="<?= $href; ?>"><?= $title; ?></a></h4>
				<hr />
				<span title="<?= $shortDescription; ?>"><?= limitString(returnText($shortDescription), 80); ?></span>
				<script>
					$('#' + '<?= $subcategoryImageId; ?>').popupImage({
						small: "<?= ImageUploader::GetPreviewImage($image, false); ?>",
						large: "<?= ImageUploader::GetOriginalImage($image, false); ?>"
					});
				</script>
			</div>
	<?php
			$localId++;
		}
	?>
</div>