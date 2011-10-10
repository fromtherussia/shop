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
		$title = safeGetItem('title', $product, '�������� �� �������');
		$shortDescription = safeGetItem('short_description', $product, '��� ��������');
		$longDescription = safeGetItem('long_description', $product, '��� ��������');
		$article = safeGetItem('article', $product, '�� ������');
		$priceWholesale = safeGetItem('price_wholesale', $product, '�� �������');
		$priceRetail = safeGetItem('price_retail', $product, '�� �������');
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
						������� ����: <?= returnText($priceWholesale); ?> ���.<br />
						��������� ����: <?= returnText($priceRetail); ?> ���.<br /><br />
						(<?php ShopPlugin\Cart::RenderProductsAmountPicker($product['id']); ?>&nbsp;/&nbsp;<a href="<?= $cartHref; ?>">������� � ����� ������</a>)
						<br />
					</span><br />
					
					<b>�������:</b> <?= returnText($article); ?><br />
					<b>������:</b> <?= $shortDescription; ?><br />
					<hr />
					<div id="complete-info">
						<h4>��������:</h4>
						<?= $longDescription; ?>
					</div>
					<div id="related-products">
						<h4>������������� ������:</h4>
						
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>