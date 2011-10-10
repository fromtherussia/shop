<style>
	#product-info #images-list {
		width: 156px;
	}
	
	#product-info #info {
		padding-left: 20px;
	}
	
	#product-info #short-info {
		margin-bottom: 20px;
	}
	
	#product-info #complete-info {
		margin-bottom: 20px;
	}
	
	#product-info #related-products {
		margin-bottom: 20px;
	}
	
	#product-info .first-image {
		float: left;
		width: 154px;
		height: 100px;
		border: 1px solid #aaa;
		background-color: #fff;
	}
	
	#product-info .first-image  img {
		max-width: 152px;
		max-height: 98px;
	}
	
	#product-info .small-image {
		float: left;
		width: 50px;
		height: 33px;
		border: 1px solid #aaa;
		background-color: #fff;
		margin-top: 4px;
	}
	
	#product-info .small-image  img {
		max-width: 48px;
		max-height: 31px;
	}
</style>
<div id="product-info">
	<script>
		$(function() {
			
		});
	</script>
	<?php
		$title = safeGetItem('title', $product, 'Название не указано');
		$shortDescription = safeGetItem('short_description', $product, 'Нет описания');
		$longDescription = safeGetItem('long_description', $product, 'Нет описания');
		$article = safeGetItem('article', $product, 'не указан');
		$priceWholesale = safeGetItem('price_wholesale', $product, 'не указана');
		$priceRetail = safeGetItem('price_retail', $product, 'не указана');
	?>
	<div id="short-info">
		<table>
			<tr>
				<td id="images-list">
					<?php
						$isFirstImage = true;
						$localImageId = 0;
						foreach ($images as $image) {
							$imageClass = $isFirstImage ? 'first-image' : 'small-image';
							$productImageId = 'product-image-' . $localImageId;
							?>
								<div id="<?= $productImageId; ?>" class="<?= $imageClass; ?>">&nbsp;</div>
								<script>
									$('#' + '<?= $productImageId; ?>').popupImage({
										small: "<?= ImageUploader::GetPreviewImage($image, false); ?>",
										large: "<?= ImageUploader::GetOriginalImage($image, false); ?>"
									});
								</script>
							<?php
							$localImageId ++;
							$isFirstImage = false;
						}
					?>
					<br class="clear">
				</td>
				<td id="info">
				<?php
					$cartHref = Command::GetRedirectUrl('ClientCart');
				?>
					<h2><?= returnText($title); ?></h2>
					<span class="price">
						Оптовая цена: <?= returnText($priceWholesale); ?> руб.<br />
						Розничная цена: <?= returnText($priceRetail); ?> руб.<br /><br />
						(<?php ShopPlugin\Cart::RenderProductsAmountPicker($product['id']); ?>&nbsp;/&nbsp;<a href="<?= $cartHref; ?>">перейти к моему заказу</a>)
						<br />
					</span><br />
					
					<b>Артикул:</b> <?= returnText($article); ?><br />
					<b>Кратко:</b> <?= $shortDescription; ?><br />
					<hr />
					<div id="complete-info">
						<h4>Описание:</h4>
						<?= $longDescription; ?>
					</div>
					<div id="related-products">
						<h4>Сопутствующие товары:</h4>
						
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>