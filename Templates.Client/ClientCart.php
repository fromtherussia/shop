<h3>Мой заказ</h3>
<form method="POST" action="<?= Command::GetRedirectUrl('ClientPay');?>">
	<table>
		<!-- Retail -->
		<?php 
			if ($userType == ShopPlugin\Client::TYPE_UNKNOWN || $userType == ShopPlugin\Client::TYPE_JURIDICAL_PERSON) {
		?>
		<tr>
			<td colspan="6">
				<?php
					if ($userType == ShopPlugin\Client::TYPE_UNKNOWN) {
				?>
				<h4>При покупке оптом</h4>
				<?php
					}
				?>
				<hr />
			</td>
		</tr>
		<tr>
			<td colspan="6">
			<?php
				$wholesalePricesTemplate = new Template('ClientCartItems');
				$wholesalePricesTemplate->SetParam('products', $products);
				$wholesalePricesTemplate->SetParam('price', $priceWholesale);
				$wholesalePricesTemplate->SetParam('precent', $precentWholesale);
				$wholesalePricesTemplate->SetParam('priceDiscounted', $priceDiscountedWholesale);
				$wholesalePricesTemplate->Render();
			?>
			</td>
		</tr>
		<?php
			}
		?>
		
		<!-- Wholesale -->
		<?php
			if ($userType == ShopPlugin\Client::TYPE_UNKNOWN || $userType == ShopPlugin\Client::TYPE_INDIVIDUAL_PERSON) {
		?>
		<tr>
			<td colspan="6">
				<?php
					if ($userType == ShopPlugin\Client::TYPE_UNKNOWN) {
				?>
				<h4>При покупке в розницу</h4>
				<?php
					}
				?>
				<hr />
			</td>
		</tr>
		<tr>
			<td colspan="6">
			<?php
				$retailPricesTemplate = new Template('ClientCartItems');
				$retailPricesTemplate->SetParam('products', $products);
				$retailPricesTemplate->SetParam('price', $priceRetail);
				$retailPricesTemplate->SetParam('precent', $precentRetail);
				$retailPricesTemplate->SetParam('priceDiscounted', $priceDiscountedRetail);
				$retailPricesTemplate->Render();
			?>
			</td>
		</tr>
		<?php
			}
		?>

		<tr>
			<td colspan="4">&nbsp;</td>
			<td colspan="2" class="alright">
				<?php
					if ($userType == ShopPlugin\Client::TYPE_UNKNOWN) {
				?>
				<button>Оформить заказ</button>
				<?php
					} else {
				?>
				<div>
				<?php
						renderArticle('orderCases');
				?>
				</div>
				<input type="checkbox" /><b>Я согласен с условиями</b><br /><br />
				<button>Оплатить заказ</button>
				<?php
					}
				?>
			</td>
		</tr>
	</table>
<form>
<script>
	$(function() {
		$('div.icon').hover(
			function() { $(this).addClass('ui-state-hover'); }, 
			function() { $(this).removeClass('ui-state-hover'); }
		);
	});
</script>