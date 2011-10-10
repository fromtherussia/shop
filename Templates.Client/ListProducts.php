<style>
	#products-list .product {
		width: 190px;
		padding: 15px;
		border: 1px solid transparent;
	}
	
	#products-list .product:hover {
		border: 1px solid #ccc;
		background-color: #ddd;
	}
	
	#products-list .product .image {
		width: 100px;
		height: 66px;
		border: 1px solid #ccc;
	}
	
	#products-list .product .image img {
		max-width: 98px;
		max-height: 64px;
	}
</style>
<div id="products-list">
	<?php
		$imageId = 0;
		foreach ($products as $product) {
			$productId = $product['id'];
			$href = getProductUrl($category_id, $product['id']);
			$shortDescription = $product['short_description'];
			echo '<div class="product left">';
			
			$images = Catalog::GetProductImages($productId);
			
			$image = count($images) > 0 ? $images[0] : '';
			$productImageId = 'product-image-' . $imageId;
			$imageId ++;
		?>
			<div id="<?= $productImageId; ?>" class="image">&nbsp;</div>
			<script>
				$('#' + '<?= $productImageId; ?>').popupImage({
					small: "<?= ImageUploader::GetPreviewImage($image, false); ?>",
					large: "<?= ImageUploader::GetOriginalImage($image, false); ?>"
				});
			</script>
		<?php
			echo "<h4><a href=\"$href\">";
			echo $product['title'];
			echo "</a></h4>";
			echo '<hr />';
			echo limitString($shortDescription, 80);
			echo '</div>';
		}
	?>
</div>